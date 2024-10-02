<style>
.overlay-menu {
    position: fixed;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background-color: #fff;
    transition: left 0.3s ease;
    z-index: 999;
    overflow:scroll;
}
.close-button {
    position: absolute;
    top: 20px;
    right: 20px;
    background-color: transparent;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #000;
}
.main-menu {
    position: absolute;
    top: 0;
    left: 0;
    padding: 20px;
    list-style: none;
}
.main-menu li {
    margin: 10px 0;
}
.main-menu a {
    color: #000;
    text-decoration: none;
    font-size: 18px;
    display: block;
}
.submenu {
    display: none;
    list-style: none;
    padding: 0;
    margin: 0;
}
.submenu li {
    margin: 5px 0;
}
.submenu a {
    color: #000;
    text-decoration: none;
    font-size: 16px;
    display: block;
}
</style>
<div id="overlayMenu" class="overlay-menu">
    <button id="closeMenuButton" class="close-button">×</button>
    <div class="sidebar sidebar-shop" id="myDIV" style="padding: 30px;">
        <style>
            .widget-collapsible .widget-body {
                padding-top: 1rem;
                padding-bottom: 0rem;
            }
            aside.col-lg-3.order-lg-first {
                box-shadow: 0px 0px 5px #357d8a;
                padding: 2em;
                height: 70%;
            }
        </style>
        <div class="widget widget-clean">
            <label>Filters:</label>
            <a href="#" class="sidebar-filter-clear">Clean All</a>
        </div>
        <input type="hidden" value="{{$category->id ?? ''}}" name="category_id" id="category_id"/>
        <div class="widget widget-collapsible">
            <h3 class="widget-title">
                <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                    Category
                </a>
            </h3>
            <div class="collapse show" id="widget-1">
                <div class="widget-body">
                    <div class="filter-items filter-items-count">

                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">

                                <input type="checkbox" class="custom-control-input category-checkbox"
                                       id="cat-all">
                                <label class="custom-control-label" for="cat-all">All</label>
                            </div>
                        </div>
                        @foreach ($get_category as $get_categories)
                            <div class="filter-item">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input category-checkbox"
                                           id="cat-{{$get_categories->id}}"
                                           name="category"
                                           value="{{$get_categories->id}}">
                                    <label class="custom-control-label" for="cat-{{$get_categories->id}}">{{$get_categories->category_name}}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="widget widget-collapsible">
            <h3 class="widget-title">
                <a data-toggle="collapse" href="#widget-2" role="button" aria-expanded="true" aria-controls="widget-4">
                    Brand
                </a>
            </h3>
            <div class="collapse show" id="widget-2">
                <div class="widget-body">
                    <div class="filter-items">
                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input brand-checkbox" id="brand-all">
                                <label class="custom-control-label" for="brand-all">All</label>
                            </div>
                        </div>
                        <div id="brand-list">
                            <style>
                                div#widget-2 {
                                    height: 200px;
                                    overflow-y: scroll;
                                }
                            </style>
                            @foreach($get_brands as  $get_brandss)
                                <div class="filter-item">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input brand-checkbox" id="brand-{{$get_brandss->id}}" name="brand" value="{{$get_brandss->id}}">
                                        <label class="custom-control-label" for="brand-{{$get_brandss->id}}">{{$get_brandss->category_name}}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget widget-collapsible">
            <h3 class="widget-title">
                <a data-toggle="collapse" href="#widget-3" role="button" aria-expanded="true" aria-controls="widget-4">
                    Product Type
                </a>
            </h3>
            <div class="collapse show" id="widget-3">
                <div class="widget-body">
                    <div class="filter-items">
                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input producttype-checkbox" id="edt"
                                       name="producttype" value="Eau De Toilette">
                                <label class="custom-control-label" for="edt">Eau De Toilette</label>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input producttype-checkbox" id="edp" name="producttype" value="Eau De Parfum">
                                <label class="custom-control-label" for="edp">Eau De Parfum</label>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input producttype-checkbox" id="cologne" name="producttype" value="Cologne">
                                <label class="custom-control-label" for="cologne">Cologne</label>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input producttype-checkbox" id="deodrant" name="producttype" value="Deodrant">
                                <label class="custom-control-label" for="deodrant">Deodrant</label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="widget widget-collapsible">
            <h3 class="widget-title">
                <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true" aria-controls="widget-4">
                    Size
                </a>
            </h3>
            <div class="collapse show" id="widget-4">
                <div class="widget-body">
                    <div class="filter-items">
                        <style>
                            .custom-control.custom-radio .custom-control-input:checked ~ .custom-control-label::before {
                                border-radius: 50%;
                            }
                            .custom-control.custom-radio .custom-control-label::before {
                                border-radius: 50%;
                            }
                        </style>
                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input productsize-checkbox" id="productsize-all">
                                <label class="custom-control-label" for="productsize-all">All</label>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input productsize-checkbox" id="1.7oz" name="product-size[]">
                                <label class="custom-control-label" for="1.7oz">1.7oz/50ml</label>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input productsize-checkbox" id="2.5oz" name="product-size[]">
                                <label class="custom-control-label" for="2.5oz">2.5oz/75ml</label>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input productsize-checkbox" id="3.0oz" name="product-size[]">
                                <label class="custom-control-label" for="3.0oz">3.0oz/90ml</label>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input productsize-checkbox" id="3.3oz" name="product-size[]">
                                <label class="custom-control-label" for="3.3oz">3.3oz/100ml</label>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input productsize-checkbox" id="4.2oz" name="product-size[]">
                                <label class="custom-control-label" for="4.2oz">4.2oz/125ml</label>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input productsize-checkbox" id="5.0oz" name="product-size[]">
                                <label class="custom-control-label" for="5.0oz">5.0oz/150ml</label>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input productsize-checkbox" id="6.7oz" name="product-size[]">
                                <label class="custom-control-label" for="6.7oz">6.7oz/200ml</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
