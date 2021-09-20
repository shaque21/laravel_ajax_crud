@extends('layouts.admin')

@section('page-title')
<!-- Page title -->
<ul class="list-inline menu-left mb-0">
    <li class="list-inline-item">
        <button type="button" class="button-menu-mobile open-left waves-effect">
            <i class="ion-navicon"></i>
        </button>
    </li>
    <li class="hide-phone list-inline-item app-search">
        <h3 class="page-title">Products</h3>
    </li>
</ul>
@endsection

@section('content')


<div class="container-fluid">
    
    <div class="row">
        <div class="col-md-10 offset-1">
            <div class="card">
                <div class="card-header d-flex justify-content-around align-items-center">
                    <h5 style="font-size: 16px">All Products</h5>
                    {{-- <a id="create_btn" data-toggle="modal" data-target="#creatModal" class="btn btn-sm btn-purple"> Add Category</a> --}}

                    <button type="button" class="btn btn-sm btn-purple" id="addBtn" name="button"
                        data-target="#add" data-toggle="modal">Add Product
                    </button>

                </div>

                {{-- Table start --}}

                <div class="card-body table-responsive">
                    <span class="showError"></span>
                    <table class="table table-striped text-center table-hover table-bordered table-sm" id="productTable">
                        <thead class="thead-dark">
                            <tr>
                              <th>Product Name</th>
                              <th>Product Category</th>
                              <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($products))

                                @foreach ($products as $item)
                                    <tr class="item{{ $item->id }}">
                                        <td class="">{{ $item->product_name }}</td>
                                        <td class="">{{ $item->product_category->procate_name }}</td>
                                        <td class="actionBtn">
                                            <button type="button" class="btn btn-dark mr-3 btn-sm"
                                                onclick="viewItem({{ $item->id }})">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-success mr-3 btn-sm"
                                                onclick="editItem({{ $item->id }})">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger mr-3 btn-sm"
                                                onclick="deleteItem({{ $item->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- table end --}}

                <!-- Add category modal start -->

                <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
                    <div class="modal-dialog" role="document">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="noteModal">Add New Product</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="POST" id="productAddForm">@csrf

                                <div class="modal-body">
                                    <div class="card">

                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="product_name" class="form-label">Product Name</label>
                                                <input required type="text" class="form-control form-control-sm" name="product_name"  placeholder="Enter product name" value="">
                                            </div>
                                            @php

                                                $categories = App\Models\ProductCategory::orderBY('id','ASC')->get();

                                            @endphp
                                            <div class="mb-3">
                                                <label for="category" class="form-label">Category Name</label>
                                                <select required class="form-control form-control-sm" name="category">
                                                    <option>Select Category</option>
                                                    @foreach($categories as $category)

                                                    <option value="{{$category->id}}">{{$category->procate_name}}</option>

                                                    @endforeach
                                                    
                                                </select>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    {{-- <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button> --}}
                                    <button type="submit" class="btn btn-purple btn-sm btn-block">Save Product</button>
                                </div>
                            </form>
                        </div>
                    </form>
                    </div>
                </div>

                <!-- Add category modal end -->

                 <!-- view category modal start -->

                 <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="view" aria-hidden="true">
                    <div class="modal-dialog" role="document">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="noteModal">View Product</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="POST" id="productViewForm">@csrf

                                <div class="modal-body">
                                    <div class="card">

                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Product Name</label>
                                                <p id="view_name"></p>
                                                {{-- <input required type="text" class="form-control form-control-sm" name="name"  placeholder="enter category name" value=""> --}}
                                            </div>
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Category Name</label>
                                                <p id="view_category"></p>
                                                {{-- <input required type="text" class="form-control form-control-sm" name="name"  placeholder="enter category name" value=""> --}}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    {{-- <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button> --}}
                                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-purple btn-sm btn-block">Close</button>
                                </div>
                            </form>
                        </div>
                    </form>
                    </div>
                </div>

                <!-- view category modal end -->

                <!-- update product category modal -->

                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="noteModal">Update Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form action="POST" id="updateCategoryForm">@csrf
                                <div class="modal-body">
                                    <div class="card">

                                        <div class="card-body">

                                            <div class="mb-3">
                                                <input type="hidden" id='hidden_id'  name="hidden_id" value="">
                                                <label for="name" class="form-label">Product Name</label>
                                                <input required type="text" value="" class="form-control form-control-sm"  name="product_name" id="edit_name"  placeholder="enter category name">
                                            </div>
                                            @php

                                                $categories = App\Models\ProductCategory::orderBY('id','ASC')->get();

                                            @endphp
                                            <div class="mb-3">
                                                <label for="category" class="form-label">Category Name</label>
                                                <select required class="form-control form-control-sm" id="edit_category" name="edit_category">
                                                    <option disabled>Select Category</option>
                                                    @foreach($categories as $category)

                                                    <option value="{{$category->id}}">{{$category->procate_name}}</option>

                                                    @endforeach
                                                    
                                                </select>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                    <button type="submit"  class="update_btn btn btn-purple btn-sm">Update Category</button>
                                    
                                </div>
                            </form>
                            
                        </div>
                    </form>
                    </div>
                </div>

                <!-- update product category modal end -->

            </div>
        </div>

    </div>

</div>
@endsection
@section('script')
<script>


var config = {
    routes: {
        add: "{!! route('product.add') !!}",
        edit: "{!! route('product.edit') !!}",
        view: "{!! route('product.view') !!}",
        update: "{!! route('product.update') !!}",
        delete: "{!! route('product.delete') !!}",
    }
};

$(document).ready(function(){
    $('#productTable').DataTable({
        'ordering':false,
    });
});

// Add form Validation
$(document).ready(function(){
    $('#productAddForm').validate({
        
        rules: {
            product_name: {
                required: true,
                maxlength: 100,
            },
            category: {
                required: true,
            }
        },
        messages: {
            product_name: {
                required: 'Please Enter Product Category Name',
            },
            category: {
                required: 'Please Select Category Name',
            }
        },
        errorPlacement: function(label,element){
            label.addClass('mt-2 text-danger');
            label.insertAfter(element);
        }
    });
});


$(document).on('submit','#productAddForm', function(event){
    event.preventDefault();
    

    $.ajax({
        url: config.routes.add,
        method: "POST",
        data: new FormData(this),
        contentType:false,
        cache: false,
        processData: false,
        dataType: 'JSON',
        success: function(response){

            if(response.success == true){

                var productTable = $('#productTable').DataTable();

                var trDOM = productTable.row.add([
                    "" + response.data.product_name + "",
                    "" + response.data.procate_name + "",
                    "<button type='button' class='btn btn-dark mr-3 btn-sm' onclick='viewItem(" +
                        response.data.id +
                        ")'> <i class='fa fa-eye'></i></button><button type='button' class='btn btn-success mr-3 btn-sm' onclick='editItem(" +
                        response.data.id +
                        ")'> <i class='fa fa-pencil-square-o'></i></button> <button type='button' class='btn btn-danger mr-3 btn-sm'  onclick='deleteItem(" +
                        response.data.id + ")'> <i  class='fa fa-trash'></i></button>"
                ]).draw().node();

                $(trDOM).addClass('item' + response.data.id + '');

                if (response.data.message) {
                    html =
                        '<div class="alert alert-success bg-success text-dark text-center" role="alert">' +
                        response.data.message + '</div>';
                    $('#productAddForm').trigger('reset');
                    $('#add').modal('hide');

                }
                $('.showError').fadeIn(100).html(html);
                $('.showError').fadeOut(3000);

            }else {
                html =
                    '<div class="alert alert-danger bg-danger text-danger text-center" role="alert">' +
                    response.data.error + '</div>';
                // $('#addSlider').modal('hide');
                $('.showError').fadeIn(100).html(html);
                $('.showError').fadeOut(3000);
            }
        },


    });

});

// view single 
function viewItem(id) {
    $.ajax({
        url: config.routes.view,
        method: "POST",
        data: {
            id: id,
            _token: "{{ csrf_token() }}"
        },
        dataType: "json",
        success: function(response) {
            if (response.success == true) {
                $('#view_name').text(response.data.product_name);
                $('#view_category').text(response.data.procate_name);
                
                $('#viewModal').modal('show');

            } //success end

        }
    }); //ajax end
}

// // Update product
// //validation
$(document).ready(function() {
    $("#updateCategoryForm").validate({
        rules: {
            name: {
                required: true,
                maxlength: 100,
            }
        },
        messages: {
            name: 'Please Enter Product Category Name',
        },
        errorPlacement: function(label,element){
            label.addClass('mt-2 text-danger');
            label.insertAfter(element);
        }
    });
});

function editItem(id) {
    
    $.ajax({
        url: config.routes.edit,
        method: "POST",
        data: {
            id: id,
            _token: "{{ csrf_token() }}"
        },
        dataType: "json",
        success: function(response) {
            if (response.success == true) {

                $('#edit_name').val(response.data.product_name)
                $('#edit_category').val(response.data.procate_id)
                
                $('#hidden_id').val(response.data.id)

                
                $('#editModal').modal('show');

            } //success end

        }
    });
    $(document).on('submit', '#updateCategoryForm', function(event) {
        event.preventDefault();
        $.ajax({
            url: config.routes.update,
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function(response) {

                if (response.success == true) {
                    $('.item' + response.data.id).html(
                        "<td>" + response.data
                        .product_name + "</td><td>" + response.data.procate_name + "<td><button type='button' class='btn btn-dark mr-3 btn-sm' onclick='viewItem(" +
                        response.data.id +
                        ")'> <i class='fa fa-eye'></i></button><button type='button' class='btn btn-success mr-3 btn-sm' onclick='editItem(" +
                        response.data.id +
                        ")'> <i class='fa fa-pencil-square-o'></i></button> <button type='button' class='btn btn-danger mr-3 btn-sm'  onclick='deleteItem(" +
                        response.data.id +
                        ")'> <i  class='fa fa-trash'></i></button></td>");
                    // $('#event_class_table').DataTable().draw();
                    // console.log(data);
                    if (response.data.message) {


                        html =
                            '<div class="alert alert-success bg-success text-dark text-center" role="alert">' +
                            response.data.message + '</div>';
                        $('#updateCategoryForm')[0].reset();
                        $('#editModal').modal('hide');
                        
                    }
                    $('.showError').fadeIn(100).html(html);
                    $('.showError').fadeOut(3000);
                    // setTimeout(function () {
                    //     $('#event_class_edit_form').modal('hide');
                    // }, 2800);
                } else {
                    html =
                        '<div class="alert alert-danger bg-danger text-danger text-center" role="alert">' +
                        response.data.error + '</div>';
                    $('.showError').fadeIn(100).html(html);
                    $('.showError').fadeOut(3000);

                }

            }, //success end

            
        });
    });

}

// // delete part
function deleteItem(id) {
    
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: config.routes.delete,
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                success: function(response) {

                    if (response.success === true) {
                        Swal.fire(
                            'Deleted!',
                            "" + response.data.message + "",
                            'success'
                        )
                        // swal("Done!", response.data.message, "success");
                        $('#productTable').DataTable().row('.item' + response.data.id)
                            .remove()
                            .draw();
                    } else {
                        Swal.fire("Error!", "Can't delete item", "error");
                    }
                }
            });

        }
    })


}

</script>
@endsection
