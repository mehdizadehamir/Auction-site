<div class="pricing-header px-3 py-3 pt-md-5 pb-md-2 mx-auto text-center">
    <p class="lead">
        Let's start selling everything you'd like by the highest rates.
    </p>
</div>

<div class="container">
    <div class="dropdown-divider"></div>
    <div class="row mt-3">
        <div class="col-12 col-md-11 mx-auto text-left" id="warnIdSales"></div>
    </div>
    <div class="row pt-2">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-md-5 mx-auto">
                    <h3 class="mb-4">Create new auction</h3>
                    <form method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <label for="sellName">Product name</label>
                                <input id="sellName" type="text" class="form-control" placeholder="ex. Black bicycle">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="sellPrice">Product price (USD)</label>
                                <input id="sellPrice" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="sellImg">Product image</label>
                                <input id="sellImg" type="file" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12">
                                <button type="button" id="btnSubmit" class="form-control btn" style="color: #000;background: var(--yellow-color)">
                                    <span>Click to create</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-md-5 mx-auto">
                    <div id="imgPlaceHolder" class="imgPlaceHolder d-none">
                        <img src="" style="width: 100%; height: 100%;border: none;box-shadow: none;" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    const ajaxPath = '<?=$__CONTROLLERS.'profile/sales/controller.php';?>';

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imgPlaceHolder > img').attr('src',e.target.result);
                $('#imgPlaceHolder').attr('class','imgPlaceHolder');
            };

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $(document).ready(function () {

        const sellNameElem = $('#sellName');
        const sellPriceElem = $('#sellPrice');
        const warnIdSales = $('#warnIdSales');
        const sellImgElem = $('#sellImg');

        $("#sellImg").change(function() {
            readURL(this);
        });


        $('#btnSubmit').click(function () {

            const name = sellNameElem.val();
            const price = sellPriceElem.val();

            if(name == ""){
                showWarnInside(warnIdSales,'alert-danger',__WARN_PROFILE_EMPTY_NAME);
                return;
            }
            if(price == "" || price == 0){
                showWarnInside(warnIdSales,'alert-danger',__WARN_PROFILE_EMPTY_PRICE);
                return;
            }
            if(isNaN(price)){
                showWarnInside(warnIdSales,'alert-danger',__WARN_PROFILE_WRONG_PRICE);
                return;
            }

            var form_data = new FormData();
            var file = sellImgElem.prop('files')[0];

            if(file != null) {

                form_data.append( 'image' ,file);
                form_data.append( 'name'  ,name);
                form_data.append( 'price' ,price);

                var request = new XMLHttpRequest();
                request.addEventListener('load', function(e) {
                    console.log('=======> ' + request.response);
                    alert(e);
                });
                request.responseType = 'text';
                request.open('post', ajaxPath);
                request.send(form_data);

            }else{
                showWarnInside(warnIdSales,'alert-danger',__WARN_PROFILE_EMPTY_IMG)
            }

        });
    });
</script>