@extends('dashboard.layout.template')
@section('content')
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Tambah Database</h5>
                <small class="text-muted float-end">ini adalah form untuk menambah database</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('createTable.store') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="table_name">Table Name:</label>
                        <input type="text" class="form-control" id="table_name" name="table_name">
                    </div>
                    <div class="form-group">
                        <label for="columns">Columns:</label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dynamicTable">
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Length</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="columns[0][name]" placeholder="Enter column name"
                                            class="form-control" /></td>
                                    <td>
                                        <select name="columns[0][type]" class="form-control">
                                            <option value="string">String</option>
                                            <option value="integer">Integer</option>
                                            <option value="bigInteger">Big Integer</option>
                                            <option value="text">Text</option>
                                            <option value="date">Date</option>
                                            <option value="datetime">Datetime</option>
                                            <option value="time">Time</option>
                                        </select>
                                    </td>
                                    <td><input type="text" name="columns[0][length]" placeholder="Enter length"
                                            class="form-control" /></td>
                                    <td>
                                        <button type="button" name="add" id="add" class="btn btn-success">Add
                                            More</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="related_table">Related Table:</label>
                        <input type="text" class="form-control" id="related_table" name="related_table">
                    </div>
                    <div class="form-group mt-3">
                        <label for="foreign_key">Foreign Key Column Name:</label>
                        <input type="text" class="form-control" id="foreign_key" name="foreign_key">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dynamicTable">
                    <thead>
                        <tr>
                            <th>Table Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tables as $table)
                            <tr>
                                <td>{{ $table->Tables_in_kuncupbahari }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form
                                                action="{{ route('createTable.destroy', $table->Tables_in_kuncupbahari) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">Delete</button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ route('createTable.edit', $table->Tables_in_kuncupbahari) }}"
                                                class="btn btn-primary">Edit</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var i = 0;

        $("#add").click(function() {
            ++i;
            $("#dynamicTable").append('<tr><td><input type="text" name="columns[' + i +
                '][name]" placeholder="Enter column name" class="form-control" /></td><td><select name="columns[' +
                i +
                '][type]" class="form-control"><option value="string">String</option><option value="integer">Integer</option><option value="bigInteger">Big Integer</option><option value="text">Text</option><option value="date">Date</option><option value="datetime">Datetime</option><option value="time">Time</option></select></td><td><input type="text" name="columns[' +
                i +
                '][length]" placeholder="Enter length" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>'
            );
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });
    </script>
    <script src="https://unpkg.com/gojs/release/go.js"></script>
    <div class="row">
        <div class="col-md-12 mt-3 mb-3">
            <div class="card">
                <div class="card-body">

                    <div id="diagram" style="background-color: white; width: 100%; height: 700px"></div>
                    <script>
                        var $ = go.GraphObject.make;

                        var diagram = $(go.Diagram, "diagram");

                        var itemTempl =
                            $(go.Panel, "Horizontal",
                                $(go.Shape, {
                                        desiredSize: new go.Size(15, 15),
                                        strokeJoin: "round",
                                        strokeWidth: 3,
                                        stroke: null,
                                        margin: 2
                                    },
                                    new go.Binding("figure", "figure"),
                                    new go.Binding("fill", "color"),
                                    new go.Binding("stroke", "color")),
                                $(go.TextBlock, {
                                        stroke: "#333333",
                                        font: "bold 14px sans-serif"
                                    },
                                    new go.Binding("text", "name"))
                            );

                        diagram.nodeTemplate =
                            $(go.Node, "Auto", {
                                    selectionAdorned: true,
                                    resizable: true,
                                    layoutConditions: go.Part.LayoutStandard & ~go.Part.LayoutNodeSized,
                                    fromSpot: go.Spot.AllSides,
                                    toSpot: go.Spot.AllSides,
                                    isShadowed: true,
                                    shadowOffset: new go.Point(3, 3),
                                    shadowColor: "#C5C1AA"
                                },

                                $(go.Shape, "RoundedRectangle", {
                                    fill: 'white',
                                    stroke: "#eeeeee",
                                    strokeWidth: 3
                                }),

                                $(go.Panel, "Table", {
                                        margin: 8,
                                        stretch: go.GraphObject.Fill
                                    },
                                    $(go.RowColumnDefinition, {
                                        row: 0,
                                        sizing: go.RowColumnDefinition.None
                                    }),
                                    $(go.TextBlock, {
                                        row: 0,
                                        alignment: go.Spot.Center,
                                        margin: new go.Margin(0, 24, 0, 2),
                                        font: "bold 16px sans-serif"
                                    }, new go.Binding("text", "name")),

                                    $("PanelExpanderButton", "LIST", {
                                        row: 0,
                                        alignment: go.Spot.TopRight
                                    }),
                                    $(go.Panel, "Vertical", {
                                            name: "LIST",
                                            row: 1,
                                            padding: 3,
                                            alignment: go.Spot.TopLeft,
                                            defaultAlignment: go.Spot.Left,
                                            stretch: go.GraphObject.Horizontal,
                                            itemTemplate: itemTempl
                                        },
                                        new go.Binding("itemArray", "fields"), {
                                            itemTemplate: $(go.Panel, "Horizontal",
                                                $(go.TextBlock, {
                                                    width: 80
                                                }, new go.Binding("text", "")),
                                            )
                                        }
                                    )
                                )
                            );

                        diagram.linkTemplate =
                            $(go.Link, {
                                    selectionAdorned: true,
                                    layerName: "Foreground",
                                    reshapable: true,
                                    routing: go.Link.AvoidsNodes,
                                    corner: 5,
                                    curve: go.Link.JumpOver
                                },
                                $(go.Shape, {
                                    stroke: "#303B45",
                                    strokeWidth: 2.5
                                }),
                                $(go.TextBlock, {
                                        textAlign: "center",
                                        font: "bold 14px sans-serif",
                                        stroke: "#1967B3",
                                        segmentIndex: 0,
                                        segmentOffset: new go.Point(NaN, NaN),
                                        segmentOrientation: go.Link.OrientUpright
                                    },
                                    new go.Binding("text", "text")),
                                $(go.TextBlock, {
                                        textAlign: "center",
                                        font: "bold 14px sans-serif",
                                        stroke: "#1967B3",
                                        segmentIndex: -1,
                                        segmentOffset: new go.Point(NaN, NaN),
                                        segmentOrientation: go.Link.OrientUpright
                                    },
                                    new go.Binding("text", "toText"))
                            );

                        var model = $(go.GraphLinksModel);
                        model.nodeDataArray = {!! json_encode($nodes) !!};
                        model.linkDataArray = {!! json_encode($links) !!};

                        diagram.model = model;
                    </script>

                </div>
            </div>
        </div>
    </div>
    <script id="code">
        var names = {};

        function init() {

            const $ = go.GraphObject.make;

            myDiagram = $(go.Diagram, "myDiagramDiv", {
                initialAutoScale: go.Diagram.UniformToFill,
                layout: $(go.TreeLayout, {
                    nodeSpacing: 5,
                    layerSpacing: 30,
                    arrangement: go.TreeLayout.ArrangementFixedRoots,
                }),
            });

            myDiagram.nodeTemplate = $(
                go.Node,
                "Horizontal", {
                    selectionChanged: nodeSelectionChanged
                },
                $(
                    go.Panel,
                    "Auto",
                    $(go.Shape, {
                        fill: "#1F4963",
                        stroke: null
                    }),
                    $(
                        go.TextBlock, {
                            font: "bold 13px Helvetica, bold Arial, sans-serif",
                            stroke: "white",
                            margin: 3,
                        },
                        new go.Binding("text", "key")
                    )
                ),
                $("TreeExpanderButton")
            );

            myDiagram.linkTemplate = $(
                go.Link, {
                    selectable: false
                },
                $(go.Shape)
            );

            myDiagram.model = new go.TreeModel({
                isReadOnly: true,
                nodeDataArray: traverseDom(document.activeElement),
            });
        }


        function traverseDom(node, parentName, dataArray) {
            if (parentName === undefined) parentName = null;
            if (dataArray === undefined) dataArray = [];

            if (!(node instanceof Element)) return;

            if (node.id === "navSide" || node.id === "navTop") return;

            var name = getName(node);
            var data = {!! json_encode($nodes) !!};
            dataArray.push(data);

            if (parentName !== null) {
                data.parent = parentName;
            }

            var l = node.childNodes.length;
            for (var i = 0; i < l; i++) {
                traverseDom(node.childNodes[i], name, dataArray);
            }
            return dataArray;
        }


        function getName(node) {
            var n = node.nodeName;
            if (node.id) n = n + " (" + node.id + ")";
            var namenum = n;
            var i = 1;
            while (names[namenum] !== undefined) {
                namenum = n + i;
                i++;
            }
            names[namenum] = node;
            return namenum;
        }


        function nodeSelectionChanged(node) {
            if (node.isSelected) {
                names[node.data.name].style.backgroundColor = "lightblue";
            } else {
                names[node.data.name].style.backgroundColor = "";
            }
        }
        window.addEventListener("DOMContentLoaded", init);
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    @if (Session::has('message'))
        <script>
            Swal.fire(
                'Success!',
                '{{ Session::get('message') }}',
                'success'
            )
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            Swal.fire(
                'Error!',
                '{{ Session::get('error') }}',
                'error'
            )
        </script>
    @endif
@endsection
