<style>
    .card-option {
        display: inline-block;
        margin: 10px;
        text-align: center;
    }

    input[type="radio"] {
        display: none;
    }

    label {
        cursor: pointer;
        display: block;
    }

    input[type="radio"]:checked {
        border: 1px solid rgb(111, 111, 255) !important;
        border-radius: 5px;
        color: #fff;
        background-color: #595cd9;
        border-color: #595cd9;
    }
</style>
<div class="modal fade" id="iconku" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" id="search" placeholder="Search...">
                </div>

                <div class="card-option">
                    <button class="btn btn-outline-primary ikon p-3" for="219">
                        <input type="radio" id="219" name="icon" value="219"
                            onclick="document.getElementById('basic-icon-default-phone').value='bx bxl-algolia'">
                        <label for="219"><i class='bx bxl-algolia'></i></i></label>
                        <p class="mb-0"><small>algolia</small></p>
                    </button>
                </div>
                <div class="card-option">
                    <button class="btn btn-outline-primary ikon p-3">
                        <input type="radio" id="213" name="icon" value="213"
                            onclick="document.getElementById('basic-icon-default-phone').value='bx bxl-facebook-circle'">
                        <label for="213"><i class='bx bxl-facebook-circle'></i></i></label>
                        <p class="mb-0"><small>fb</small></p>
                    </button>
                </div>
                <div class="card-option">
                    <button class="btn btn-outline-primary ikon p-3">
                        <input type="radio" id="2" name="icon" value="2"
                            onclick="document.getElementById('basic-icon-default-phone').value='bx bxs-user-circle'">
                        <label for="2"><i class='bx bx bxs-user-circle'></i></i></label>
                        <p class="mb-0"><small>user</small></p>
                    </button>
                </div>
                <div class="card-option">
                    <button class="btn btn-outline-primary ikon p-3">
                        <input type="radio" id="card4" name="icon" value="card4"
                            onclick="document.getElementById('basic-icon-default-phone').value='bx bx-menu'">
                        <label for="card4"><i class='bx bx-menu'></i></i></label>
                        <p class="mb-0"><small>menu</small></p>
                    </button>
                </div>
                <div id="not-found" class="text-center" style="display:none;">Tidak ada icon</div>
            </div>
            <div class="modal-footer">
                <button id="cancel-button" class="btn btn-outline-primary">Batalkan</button>
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                    Ok
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    const cancelButton = document.getElementById("cancel-button");
    cancelButton.addEventListener("click", function() {
        const selectedRadio = document.querySelector("input[type='radio']:checked");
        document.getElementById("basic-icon-default-phone").value = "";
        if (selectedRadio) {
            selectedRadio.checked = false;
        }
    });

    const search = document.getElementById("search");
    search.addEventListener("keyup", function() {
        const value = search.value.toLowerCase().trim();

        const cards = document.querySelectorAll(".ikon");
        let notFound = true;
        let firstFound;
        cards.forEach(function(card, index) {
            const input = card.querySelector("input");
            const val = input.value.toLowerCase();

            if (val.includes(value)) {
                notFound = false;
                card.style.display = "block";
                if (!firstFound) {
                    firstFound = card;
                }
            } else {
                card.style.display = "none";
            }
        });

        if (firstFound) {
            firstFound.parentNode.prepend(firstFound);
        }

        if (notFound) {
            document.getElementById("not-found").style.display = "block";
        } else {
            document.getElementById("not-found").style.display = "none";
        }
    });
</script>
