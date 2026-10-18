    $(function () {
        var enc_invoice_detail_gid = $('#enc_invoice_detail_gid').val();
        var btnEdit = $('#btn_edit');
        btnEdit.hide();
        $("#store").select2();
        retrieveProductData();
        // Function to handle form submission via AJAX
        $("#frmTagProducts").validate({
            rules: {
                // Specify validation rules for form fields
                box_no:{ required:true },
                length: { required:true },
                width:  { required:true },
                height: { required:true },
                weight: { required:true }
            },
           
            messages: {
                box: "Required&nbsp;&nbsp;      ",
                length:"Required&nbsp;&nbsp;      ",
                width: "Required&nbsp;&nbsp;       ",
                height:"Required&nbsp;&nbsp;      ",
                weight:"Required&nbsp;&nbsp;      "
            },
            errorPlacement: function(error, element) {
                // Check if the element has a parent form-group
                var parentFormGroup = element.closest('.input-group');
                if (parentFormGroup.length) {
                    // Append error message after the parent form-group
                    error.insertAfter(parentFormGroup);
                } else {
                    // Use default error placement if parent form-group is not found
                    error.insertAfter(element);
                }
            },
            // Handle form submission
            submitHandler: function(form) {
                $.ajax({
                    url: "partials/update_box_tagged_products.php", // Replace with your PHP script to handle form submission
                    type: "POST",
                    data: $(form).serialize(), // Serialize form data
                    dataType: 'json',
                    beforeSend:function(){
                        $('#loader').show();
                    },
                    success: function(response) {
                        // Handle success response
                        if(response.msg == 'Success') {
                            //$("#tblAddedItems").DataTable().ajax.reload();
                            swal({
                                title: 'Success',
                                text: "Product details added successfully",
                                icon: 'success',
                            });
                            retrieveProductData();

                        }
                        else
                        {
                            swal({
                                title: 'Error',
                                text: response.msg_detail,
                                icon: 'warning',
                            });

                        }
                    },
                    error: function(xhr, status, error) {
                        swal({
                            title: 'Error',
                            text: 'Unexpected error occured. Please try again.',
                            icon: 'warning',
                        });
                    },
                    complete : function() {
                        $('#loader').hide();
                        $("#product_code").val('');
                        $('#selected_product_code').val('');
                        $("[id$='_quantity']").val('');
                        $('#btn_add').show();
                        $('#btn_edit').hide();
                        $('#btn_status').val('add');
                        $('#product_code').attr('readonly',false);
                        $('#selected_product_code').attr('readonly',false);

                    }
                });
            }
        });

        var dtAddedItems = 
            // Initialize DataTable
            $('#tblAddedItems').DataTable({
                // Configure DataTable options
                // Configure DataTable options
                columnDefs: [
                    {
                        targets: 0, // Target the first column (index 0)
                        width: "5%", // Set a fixed width for the column
                        className: "dt-center" // Optionally, center-align the content
                    },
                    {
                        targets: 2, // Target the second column (index 1)
                        width: "50%" // Set the width of the column to 50%
                    }
                ]
            });

        // Product code autocomplete
        $("#product_code").autocomplete({
            source: "partials/autocomplete_product_code.php?mode=tag",  // Server-side script to fetch product data
            minLength: 3,  // Minimum characters before autocomplete starts
            search: function() {
                // Optionally, show a loading indicator when search starts
                $("#loader").show();
            },
            response: function(event, ui) {
                // Optionally, hide loader when suggestions are ready
                $("#loader").hide();
                if (!ui.content || ui.content.length === 0) {
                    $("#product_code").val('');
                    $("#selected_product_code").val('');
                    alert("No results found!");  // Optionally, notify user no results were found
                }
            },
            select: function(event, ui) {
                // When an option is selected, populate the hidden input with the product code
                if (ui.item) {
                    // Assuming the server returns item in the format "code - name"
                    var productDetails = ui.item.value.split(" - ");
                    $("#selected_product_code").val(productDetails[0]);  // Store the product code
                }
            }
        });
        function swalMessage(fieldId, fieldName )
        {
            swal({
                title: 'Error',
                text: 'Please enter '+ fieldName,
                icon: 'warning',
            });
            $(fieldId).focus();
        }
        
        $('#btnEditBox').click(function(){
            //trim and validated
            var box_no = $.trim($('#box_no').val());
            var length = $.trim($('#length').val());
            var width = $.trim($('#width').val());
            var height = $.trim($('#height').val());
            var weight = $.trim($('#weight').val());
            var misc_no = $.trim($('#misc_no').val());
            if(box_no == '')
            {
                swalMessage('#box_no', 'Box no');
                return false;
            }
            else if(length == '')
            {   
                swalMessage('#length', 'Length');
                return false;
            }
            else if(width == '')
            {
                swalMessage('#width', 'Width');
                return false;
            }
            else if(height == '')
            {
                swalMessage('#height', 'Height');
                return false;
            }
            else if(weight == '')
            {
                swalMessage('#weight', 'Weight');
                return false;
            }
            else if(misc_no == '')
            {
                swalMessage('#misc_no', 'Misc no');
                return false;
            }
            else
            {
                $.ajax({
                    url:'partials/update_box_data.php',
                    type: 'post',
                    data: { box_no: box_no, length:length, width:width, height:height, weight:weight, misc_no:misc_no,enc_invoice_detail_gid: enc_invoice_detail_gid },
                    dataType:'json',
                    beforeSend:function(){
                        $('#loader').show();
                    },
                    success:function(res){
                        if(res.msg == 'Success')
                        {
                            swal({
                                title: 'Success',
                                text: 'Box details updated successfully.',
                                icon: 'success',
                            });

                        }
                        else
                        {
                            swal({
                                title: 'Warning',
                                text: 'Unexpected error occured.',
                                icon: 'warning',
                            });
                        }
                    },
                    complete:function(){
                        $('#loader').hide();
                    }
                });
            }
        });

        function retrieveProductData()
        {
            var badge_style = 'warning';
            var invoice_no =  $('#invoice_no').val();
            var box_no =  $('#box_no').val();
            $.ajax({
                url:'partials/fetch_product_quantity_data.php',
                type: 'post',
                data: { invoice_no: invoice_no, box_no:box_no },
                dataType:'json',
                beforeSend:function(){
                    $('#loader').show();
                },
                success:function(res){
                    if(res.msg == 'Success')
                    {
                        dtAddedItems.clear().draw();
                        if(res.msg_detail.length > 0)
                        {
                            var data = res.msg_detail;
                            var html = '';
                            //Lets loop through the data and create a table row for each record and bind to datatable
                            var counter  = 1;
                            var measurement = '';
                            $.each(res.msg_detail, function(index, value) {
                                var store_list = '';
                                $.each(res.store_detail,function(index2, value2) {
                                    
                                    if(value.product_code == value2.product_code)
                                    {
                                        store_list +=  "<label class='badge badge-"+badge_style+"' >"+value2.location_name +": "+value2.quantity + "</label><br>";
                                        if(badge_style == 'warning') badge_style = 'success'; else badge_style = 'warning';
                                    }
                                    
                                });

                                dtAddedItems.row.add([
                                                    counter, 
                                                    value.product_code,
                                                    value.product_name, 
                                                    store_list,                                                    
                                                    "<a href='#' class='badge badge-info edit-product'>Edit</a>", 
                                                    "<a href='#' class='badge badge-danger delete-product'>Delete</a>"
                                                ]).draw();
                                counter ++;
                            });

                            $.each(res.store_detail, function(index,value){
                                var store_id = value.location_gid + "_quantity";
                                //console.log(store_id);
                               // $('#'+store_id).val(value.quantity);
                            });
                        }
                        $('#loader').hide();
                    }
                }
            });            
        }
        // Delete Product
        $("#tblAddedItems tbody").on("click", "td:nth-child(6)", function (e) {
            e.preventDefault();
            var product_code = $(this).closest('tr').find('td:nth-child(2)').text(); 
            var box_no = $('#box_no').val();
            var enc_invoice_no = $('#enc_invoice_no').val();
            //Ajax call to update quantity
            swal({
                title: "Confirmation",
                text: " Are you sure you want to delete this product code ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url:'partials/delete_invoice_tagged_products.php',
                        type: 'post',
                        data: { selected_product_code: product_code, enc_invoice_no: enc_invoice_no, box_no: box_no },
                        dataType:'json',
                        beforeSend:function(){
                            $('#loader').show();
                        },
                        success:function(res){
                            if(res.msg == 'Success')
                            {
                                swal({
                                        title: 'Success',
                                        text: "Product deleted successfully",
                                        icon: 'success',
                                    });
                                retrieveProductData();
                            }
                        },
                        error: function(xhr, status, error) {
                            swal({
                                title: 'Error',
                                text: 'Unexpected error occured. Please try again.',
                                icon: 'warning',
                            });
                        },
                        complete : function() {
                            $('#loader').hide();
                            $("#product_code").val('');
                            $('#selected_product_code').val('');
                            $('#quantity').val('');
                            $('#btn_add').show();
                            $('#btn_edit').hide();
                            $('#btn_status').val('add');
                        }                
                    });
                }
            });
        });

        // Edit Product
        $("#tblAddedItems tbody").on("click", "td:nth-child(5)", function (e) {
            event.preventDefault();
            var product_code = $(this).closest('tr').find('td:nth-child(2)').text(); 
            var product_name = $(this).closest('tr').find('td:nth-child(3)').text();
            var box_no = $('#box_no').val();
            var invoice_no = $('#invoice_no').val();
            //Enable edit
            $.ajax({
                        url:'partials/get_box_stores_quantity.php',
                        type: 'post',
                        data: { selected_product_code: product_code, invoice_no: invoice_no, box_no:box_no },
                        dataType:'json',
                        beforeSend:function(){
                            $('#loader').show();
                        },
                        success:function(res){
                            if(res.msg == 'Success')
                            {
                                $.each(res.msg_detail, function(index, value) {
                                    var store_id = value.location_gid + "_quantity";
                                    $('#'+store_id).val(value.quantity);
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            swal({
                                title: 'Error',
                                text: 'Unexpected error occured. Please try again.',
                                icon: 'warning',
                            });
                        },
                        complete : function() {
                            $('#loader').hide();
                            $('#selected_product_code').val(product_code);
                            $('#product_code').val(product_name);
                            $('#product_code').attr('readonly',true);
                            $('#selected_product_code').attr('readonly',true);
                            $('#btn_add').hide();
                            $('#btn_edit').show();
                            $('#btn_status').val('edit');
                        }                
                    });
        });

    });
