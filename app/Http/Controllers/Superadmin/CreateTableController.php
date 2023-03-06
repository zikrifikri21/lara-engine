<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;



class CreateTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = Menu::where('parent_id', null)->get();
        $tables = DB::select('SHOW TABLES');
        $databases = DB::select('SHOW DATABASES');
        $databases = array_map(function ($database) {
            return $database->Database;
        }, $databases);
        return view('dashboard.superadmin.createtable.index', compact('menu', 'tables', 'databases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu = Menu::where('parent_id', null)->get();
        $databases = DB::select('SHOW DATABASES');
        $databases = array_map(function ($database) {
            return $database->Database;
        }, $databases);
        return view('dashboard.superadmin.createtable.database', compact('menu', 'databases'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $table_name = $request->input('table_name');
        $columns = $request->input('columns');

        if (Schema::hasTable($table_name)) {
            return redirect()->back()->with('error', 'Table ' . $table_name . ' Sudah ada!');
        }

        Schema::create($table_name, function ($table) use ($columns, $request) {
            $table->bigIncrements('id');
            foreach ($columns as $column) {
                $type = $column['type'];
                $name = $column['name'];
                $length = $column['length'];

                if ($type === 'file' || $type === 'image') {
                    $table->text($name)->dafault('storage/default.jpg');
                } else {
                    switch ($type) {
                        case 'string':
                            $table->string($name, $length)->nullable();
                            break;
                        case 'integer':
                            $table->integer($name)->nullable();
                            break;
                        case 'bigInteger':
                            $table->bigInteger($name)->nullable();
                            break;
                        case 'text':
                            $table->text($name)->nullable();
                            break;
                        case 'date':
                            $table->date($name)->nullable();
                            break;
                        case 'datetime':
                            $table->datetime($name)->nullable();
                            break;
                        case 'time':
                            $table->time($name)->nullable();
                            break;
                    }
                }
            }

            $foreign_key = $request->input('foreign_key');
            $related_table = $request->input('related_table');
            if (!empty($foreign_key) && !empty($related_table)) {
                $table->unsignedBigInteger($foreign_key)->nullable();
                $table->foreign($foreign_key)->references('id')->on($related_table)->onDelete('cascade');
            }
            $table->timestamps();
        });

        $model_name = ucfirst($table_name);
        $model_template = '<?php namespace App\Models;
         use Illuminate\Database\Eloquent\Model;
         class %s extends Model
         {
            protected $fillable = [%s];
         }';
        $fillable_columns = implode(',', array_map(function ($column) {
            return '\'' . $column['name'] . '\'';
        }, $columns));
        $model_content = sprintf($model_template, $model_name, $fillable_columns);
        file_put_contents(app_path("Models/{$model_name}.php"), $model_content);

        // Ambil input dari user
        $columns = $request->input('columns');
        $column_names = [];
        foreach ($columns as $column) {
            $column_names[] = $column['name'];
        }
        $columns = $column_names;

        $rules = [];
        $messages = [];

        // Loop untuk setiap kolom
        foreach ($columns as $column) {
            // Aturan validasi untuk kolom wajib diisi
            $rules[$column] = 'required';

            // Pesan error untuk aturan validasi kolom wajib diisi
            $messages["$column.required"] = "$column field is required";
        }
        $code = '';
        if (in_array('file', $columns) || in_array('image', $columns)) {
            $file_upload_codes = [];
            foreach ($columns as $column) {
                if ($column === 'file' || $column === 'image') {
                    // Validasi dan upload file/image
                    $rules[$column] = 'required|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png';
                    $messages["$column.mimes"] = "File must be a type: pdf, doc, docx, xls, xlsx, jpg, jpeg, png";
                    if ($column === 'image') {
                        $rules[$column] .= '|max:2048';
                        $messages["$column.max"] = "Image size must not be larger than 2MB";
                    }
                    $file_name = str_replace('_', ' ', $column);
                    $file_name = ucwords($file_name);
                    $file_upload_code = '$' . $file_name . '_path = $request->file(\'' . $column . '\')->store(\'public\');';
                    $file_upload_code .= '$data[\'' . $column . '\'] = $' . $file_name . '_path;';
                    $file_upload_codes[] = $file_upload_code;
                }
            }
            if (!empty($file_upload_codes)) {
                $code = implode(PHP_EOL, $file_upload_codes);
                $code = rtrim($code, PHP_EOL);
            }
        }


        // Buat validasi unik untuk kolom-kolom yang bersifat unik
        $unique_columns = ['username', 'slug', 'email'];
        foreach ($unique_columns as $column) {
            if (in_array($column, $columns)) {
                // Aturan validasi untuk kolom yang bersifat unik
                $rules[$column] = 'unique:' . $table_name . ',' . $column;

                // Pesan error untuk aturan validasi kolom yang bersifat unik
                $messages["$column.unique"] = "$column field must be unique";
            }
        }

        $rules_str = var_export($rules, true);
        $messages_str = var_export($messages, true);

        // Buat template controller
        $controller_name = ucfirst($table_name) . 'Controller';
        $controller_template = '<?php namespace App\Http\Controllers;
        use App\Models\%s;
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\Validator;
        use Illuminate\Support\Facades\Auth;

        class %s extends Controller
        {
            public function index()
            {
                $%s = %s::all();
                return view(\'%s.index\', compact(\'%s\'));
            }

            public function create()
            {
                return view(\'%s.create\');
            }

            public function store(Request $request)
            {
                $validator = Validator::make($request->all(), %s, %s);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $%s = new %s;

                %s

                // simpan data ke database

        %s::create($request->all());

        return redirect()->route(\'%s.index\')->with(\'success\', \'Data berhasil disimpan.\');
        }

        public function show($id)
        {
            $%s = %s::findOrFail($id);

            return view(\'%s.show\', compact(\'%s\'));
        }

        public function edit($id)
        {
            $%s = %s::findOrFail($id);

            return view(\'%s.edit\', compact(\'%s\'));
        }

        public function update(Request $request, $id)
        {
            $validator = Validator::make($request->all(), %s, %s);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $%s = %s::findOrFail($id);
            $%s->update($request->all());

            return redirect()->route(\'%s.index\')->with(\'success\', \'Data berhasil diubah.\');
        }

        public function destroy($id)
        {
            $%s = %s::findOrFail($id);
            $%s->delete();

            return redirect()->route(\'%s.index\')->with(\'success\', \'Data berhasil dihapus.\');
        }
        }';


        $controller_content = sprintf(
            $controller_template,
            $model_name,
            $controller_name,
            $table_name,
            $model_name,
            $table_name,
            $table_name,
            $table_name,
            $rules_str,
            $messages_str,
            $model_name,
            $table_name,
            $code, //untuk validasi jika ada image atau file
            $model_name,
            $table_name,
            $model_name,
            $model_name,
            $model_name,
            $table_name,
            $model_name,
            $model_name,
            $model_name,
            $controller_name,
            $model_name,
            $controller_name,
            $table_name,
            $model_name,
            $table_name,
            $model_name,
            $table_name,
            $model_name,
            $table_name,
            $model_name,
            $table_name,
            $model_name,
            $model_name,
            $model_name,
            $table_name,
            $model_name,
            $model_name,
            $model_name,
            $table_name,
            $model_name,
            $model_name,
            $model_name,
            $table_name,
            $model_name,
            $model_name,
            $model_name,
            $model_name,
            $model_name,
            $table_name,
            $model_name,
            $model_name,
            $table_name,
            $model_name,
            $model_name
        );

        file_put_contents(app_path("Http/Controllers/{$controller_name}.php"), $controller_content);

        //membuat migration
        $table_name = $request->input('table_name');
        $columns = $request->input('columns');
        $foreign_key = $request->input('foreign_key');
        $related_table = $request->input('related_table');

        // Generate migration file name
        $timestamp = now()->format('Y_m_d_His');
        $migration_name = "create_" . $table_name . "_table";
        $migration_file_name = $timestamp . "_" . $migration_name;

        // Generate migration schema
        $schema = '';
        foreach ($columns as $column) {
            $type = $column['type'];
            $name = $column['name'];
            $length = $column['length'];

            switch ($type) {
                case 'string':
                    $schema .= "\$table->string('{$name}', {$length})->nullable();\n";
                    break;
                case 'integer':
                    $schema .= "\$table->integer('{$name}')->nullable();\n";
                    break;
                case 'bigInteger':
                    $schema .= "\$table->bigInteger('{$name}')->nullable();\n";
                    break;
                case 'text':
                    $schema .= "\$table->text('{$name}')->nullable();\n";
                    break;
                case 'date':
                    $schema .= "\$table->date('{$name}')->nullable();\n";
                    break;
                case 'datetime':
                    $schema .= "\$table->datetime('{$name}')->nullable();\n";
                    break;
                case 'time':
                    $schema .= "\$table->time('{$name}')->nullable();\n";
                    break;
            }
        }

        $schema .= "\$table->unsignedBigInteger('{$foreign_key}')->nullable();\n";
        $schema .= "\$table->foreign('{$foreign_key}')->references('id')->on('{$related_table}')->onDelete('cascade');\n";
        $schema .= "\$table->timestamps();\n";

        // Generate migration content
        $migration_content = "<?php\n
        \nuse Illuminate\Database\Migrations\Migration;
        \nuse Illuminate\Database\Schema\Blueprint;
        \nuse Illuminate\Support\Facades\Schema;
        \n\nclass {$migration_name} extends Migration\n{
            \n    public function up()\n    {
                \n        Schema::create('{$table_name}', function (Blueprint \$table) {
                    \n            \$table->bigIncrements('id');
                    \n{$schema}        });
                    \n    }
                    \n\n    public function down()\n    {
                        \n        Schema::dropIfExists('{$table_name}');
                        \n    }
                        \n}";

        // Create migration file
        file_put_contents(database_path("migrations/{$migration_file_name}.php"), $migration_content);


        // Membuat file view
        $columns_str = '';
        foreach ($columns as $column) {
            $columns_str .= "<th>" . $column['name'] . "</th>";
        }

        $update_form = '';
        $delete_modal = '';
        foreach ($columns as $column) {
            $type = $column['type'];
            $name = $column['name'];
            $label = ucwords(str_replace('_', ' ', $name));
            $update_form .= '
        <div class="form-group">
            <label for="' . $name . '">' . $label . '</label>
            <input type="' . ($type == 'text' ? 'textarea' : 'text') . '" class="form-control" id="' . $name . '" name="' . $name . '" value="{{ $item->' . $name . ' }}">
        </div>
    ';
        }

        $view_content = '
        @extends("dashboard.layout.template")
        @section("content")

        <div class="container">
            <h1>' . $table_name . ' List</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        ' . $columns_str . '
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($' . $table_name . ' as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        ';
        foreach ($columns as $column) {
            $name = $column['name'];
            $view_content .= '<td>{{ $item->' . $name . ' }}</td>';
        }
        $view_content .= '
                        <td>
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#edit-modal-{{ $item->id }}">Edit</a>
                            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#delete-modal-{{ $item->id }}">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @foreach($' . $table_name . ' as $item)
                <div class="modal fade" id="edit-modal-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label-{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="{{ route(\'' . $table_name . '.update\', $item->id) }}" method="POST">
                                @csrf
                                @method(\'PUT\')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="edit-modal-label-{{ $item->id }}">Edit ' . $table_name . '</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    ' . $update_form . '
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endsection';
        // Simpan view ke file baru
        $file_path = resource_path('views/' . $table_name . '_list.blade.php');
        file_put_contents($file_path, $view_content);

        return redirect()->route('createTable.index')->with('message', 'Table ' . $table_name . ' berhasil ditambahkan dan migrasi sudah dijalankan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($table_name)
    // {
    //     $table = DB::select("SHOW COLUMNS FROM $table_name");

    public function edit($Tables_in_kuncupbahari)
    {
        $columns = Schema::getColumnListing($Tables_in_kuncupbahari);
        $menu = Menu::where('parent_id', null)->get();

        return view('dashboard.superadmin.createtable.edit', compact('Tables_in_kuncupbahari', 'columns', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $table_name)
    {
        $new_columns = $request->input('columns');
        $existing_columns = Schema::getColumnListing($table_name);
        $columns_to_remove = array_diff($existing_columns, array_column($new_columns, 'name'));

        foreach ($new_columns as $new_column) {
            if (in_array($new_column['name'], $existing_columns)) {
                continue;
            }

            $type = $new_column['type'];
            $name = $new_column['name'];
            $length = $new_column['length'];

            switch ($type) {
                case 'string':
                    Schema::table($table_name, function ($table) use ($name, $length) {
                        $table->string($name, $length)->nullable();
                    });
                    break;
                case 'integer':
                    Schema::table($table_name, function ($table) use ($name) {
                        $table->integer($name)->nullable();
                    });
                    break;
                case 'bigInteger':
                    Schema::table($table_name, function ($table) use ($name) {
                        $table->bigInteger($name)->nullable();
                    });
                    break;
                case 'text':
                    Schema::table($table_name, function ($table) use ($name) {
                        $table->text($name)->nullable();
                    });
                    break;
                case 'date':
                    Schema::table($table_name, function ($table) use ($name) {
                        $table->date($name)->nullable();
                    });
                    break;
                case 'datetime':
                    Schema::table($table_name, function ($table) use ($name) {
                        $table->datetime($name)->nullable();
                    });
                    break;
                case 'time':
                    Schema::table($table_name, function ($table) use ($name) {
                        $table->time($name)->nullable();
                    });
                    break;
                case 'foreign':
                    $foreign_key = $new_column['foreign_key'];
                    $related_table = $new_column['related_table'];
                    $related_column = $new_column['related_column'];

                    Schema::table($table_name, function ($table) use ($name, $foreign_key, $related_table, $related_column) {
                        $table->unsignedBigInteger($foreign_key)->nullable();
                        $table->foreign($foreign_key)->references($related_column)->on($related_table)->onDelete('cascade');
                    });
                    break;
            }
        }

        foreach ($columns_to_remove as $column_to_remove) {
            Schema::table($table_name, function ($table) use ($column_to_remove) {
                $table->dropColumn($column_to_remove);
            });
        }

        return redirect()->route('table.index')->with('message', 'Table ' . $table_name . ' berhasil diubah!.');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($table_name)
    {
        Schema::dropIfExists($table_name);
        return redirect()->back()->with('message', 'Table ' . $table_name . ' berhasil di hapus!.');
    }
}
