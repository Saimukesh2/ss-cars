$(function () {

    //Page load initialization to fetch already added items by the user
    retrieveBoxData();
    $("#store").select2();
    $("#invoice_date").datepicker({
        dateFormat: "dd-mm-yy ", // ISO format date
        changeMonth: true,
        changeYear: true
    });
    // Function to handle form submission via AJAX
    $("#frmExportInvoice").validate({
        rules: {
            // Specify validation rules for form fields
            invoice_date: {
                required: true
            },
            country: {
                required: true
            },
            store: {
                required: true
            },
            container_cost: {
                required: true,
                number: true // Assuming it should be a number
            },
            misc_cost: {
                required: true,
                number: true // Assuming it should be a number
            },
            mb_no: {
                required: true
            },
            box_no: {
                required: true
            },
            misc_no: {
                required: true
            }
        },
       
        messages: {
            // Specify error messages for mandatory fields
            invoice_date: "Please enter invoice date",
            country: "Please select country",
            store: "Please select store",
            container_cost: {
                required: "Please enter container cost",
                number: "Please enter a valid number"
            },
            misc_cost: {
                required: "Please enter misc cost",
                number: "Please enter a valid number"
            },
            mb_no: "Please enter MB No",
            box_no: "Please enter box no",
            length:"Required",
            width:"Required",
            height:"Required",
            weight:"Required"
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
                url: "partials/add_box.php", // Replace with your PHP script to handle form submission
                type: "POST",
                data: $(form).serialize(), // Serialize form data
                dataType: 'json',
                beforeSend:function(){
                    $('#loader').show();
                },
                success: function(response) {
                    // Handle success response
                    if(response.msg == 'Success') {
                        //$("#frmExportInvoice")[0].reset();
                        //$("#tblAddedItems").DataTable().ajax.reload();
                        swal({
                            title: 'Success',
                            text: "Box details added successfully",
                            icon: 'success',
                        });
                        $('#showHideUpdate').show();
                        retrieveBoxData();

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
                    $('#box_no').val('');
                    $('#length').val('');
                    $('#width').val('');
                    $('#height').val('');
                    $('#weight').val('');
                    $('#misc_no').val('');
                }
            });
        }
    });

    $('#country').change(function() {
        var country_code = $(this).val(); // Get the selected country
        populateStore(country_code);
        
    });

    var dtAddedItems = 
        // Initialize DataTable
        $('#tblAddedItems').DataTable({
            // Configure DataTable options
        });

    function populateStore(country_code, selectedIds='')
    {
        // Make an AJAX call to fetch the store list
        $.ajax({
            url: 'partials/get_stores_list.php', // Adjust the URL to your backend endpoint
            method: 'GET',
            data: { country: country_code }, // Pass the selected country to the backend
            dataType: 'json',
            beforeSend:function(){
                $('#loader').show();
            },
            success: function(response) {
                // Clear previous options in the store select element
                $('#store').empty();
                // Populate the store select element with the received data
                if (response.msg == 'Success') {
                    $.each(response.msg_detail, function(index, store) {
                        $('#store').append($('<option>', {
                            value: store.location_gid,
                            text: store.location_name
                        }));
                    });
                } else {
                    swal({
                        title: 'Error',
                        text: response.msg_detail,
                        icon: 'warning',
                    });
                    $('#store').append($('<option>', {
                        value: '',
                        text: 'Select Store'
                    }));
                }
                // Call the callback function after populating the store options
                if (typeof callback === 'function') {
                    callback();
                }
            },
            error: function(xhr, status, error) {
                swal({
                title: 'Error',
                text: 'Unexpected error occured. Please try again.',
                icon: 'warning',
            });
            },
            complete:function(){
                $('#loader').hide();
                if(selectedIds.length !== 0)
                {
                    selectedIds.forEach(function(id) {
                        console.log("test");
                        $('#store option[value="' + id + '"]').prop('selected', true);
                    });
                }

            }
        });
    }
    
    function retrieveBoxData()
    {
        var selectedIds;
        $.ajax({
            url:'partials/fetch_temp_box_data.php',
            type: 'post',
            dataType:'json',
            beforeSend:function(){
                $('#loader').show();
            },
            success:function(res){
                if(res.msg == 'Success')
                {
                    
                    if(res.msg_detail.length > 0)
                    {
                        var data = res.msg_detail;
                        var html = '';
                        var total_weight = 0;
                        var total_volume = 0;
                        var total_value = 0;
                        var total_cost = 0;
                        var total_profit = 0;

                        // Assuming inward_date is in the format "yyyy-mm-dd"
                        var invoice_date = res.msg_detail[0].invoice_date; // Example date
                        // Convert the date string to a Date object
                        var dateObject = new Date(invoice_date);

                        // Format the date as "dd-mm-yyyy"
                        var formattedDate = dateObject.toLocaleDateString('en-IN', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        }).split('/').join('-');
                        
                        var invoice_no = res.msg_detail[0].invoice_no;
                        var country = res.msg_detail[0].country_code;
                        var container_cost = res.msg_detail[0].container_cost;
                        var misc_cost = res.msg_detail[0].misc_cost;
                        var mb_no = res.msg_detail[0].mb_no;
                        selectedIds = res.msg_detail[0].location_gid.split(',');
                        console.log(selectedIds);
                        // Call populateStore function and set store value in its success callback
                        populateStore(country, selectedIds);
                        $('#invoice_date').val(formattedDate);
                        $('#invoice_no').val(invoice_no);
                        $('#country').val(country);
                        $('#container_cost').val(container_cost);
                        $('#misc_cost').val(misc_cost);
                        $('#mb_no').val(mb_no);

                        //Lets loop through the data and create a table row for each record and bind to datatable
                        dtAddedItems.clear().draw();
                        var counter  = 1;
                        var measurement = '';
                        $.each(res.msg_detail, function(index, value) {
                            measurement = "Length - "+value.box_length + " Width - "+value.box_width + " Height - "+value.box_height + " Weight - "+value.box_weight 
                            dtAddedItems.row.add([counter, value.box_no, measurement,value.misc_no,
                                                "<a href='tag_products.php?id="+value.temp_gid+"' class='badge badge-info tag-products'>Tag Products</a>", 
                                                "<a href='#' class='badge badge-danger delete-box' data-tempgid='" + value.temp_gid + "'>Delete</a>"]).draw();
                            counter ++;
                        });
                    }
                    $('#loader').hide();
                }
            },
            complete:function(){
                $('#loader').hide();
            }
        });
    }

    //Delete box
    $("#tblAddedItems tbody").on("click", ".delete-box", function(e) {
        e.preventDefault();
        var temp_gid = $(this).data('tempgid');
        // Show confirmation dialog
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this box details!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                //Ajax call to update quantity
                $.ajax({
                    url:'partials/delete_box.php',
                    type: 'post',
                    data: { temp_gid: temp_gid },
                    dataType:'json',
                    beforeSend:function(){
                        $('#loader').show();
                    },
                    success:function(res){
                        if(res.msg == 'Success')
                        {
                            swal({
                                    title: 'Success',
                                    text: "Box details deleted successfully",
                                    icon: 'success',
                                });
                                retrieveBoxData(temp_gid);
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
                        window.location.reload();
                        $('#loader').hide();
                    }                
                });
            }
        });
    });

    //Auto complete
    $("#product_code").autocomplete({
        source: "partials/autocomplete_product_code.php",  // Server-side script to fetch product data
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

    // Create Invoice
    $('#btnCreateInvoice').on('click', function(e){
        // Check number of records in datatable
        if(dtAddedItems.data().count() > 0)
        {
            //Ajax call to update quantity
            $.ajax({
                url:'partials/create_export_invoice.php',
                type: 'post',
                dataType:'json',
                beforeSend:function(){
                    $('#loader').show();
                },
                success:function(res){
                    if(res.msg == 'Success')
                    {
                        swal({
                                title: 'Success',
                                text: "Invoice created successfully",
                                icon: 'success',
                            });
                        //redirect to invoices page
                        window.location.href = 'export_invoice_list.php';
                    }
                    else{
                        swal({
                                title: 'Error',
                                text: res.msg_detail,
                                html: true, // Enable HTML
                                icon: 'error',
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
                }                
            });
        }
        else
        {
            swal({
                            title: 'Error',
                            text: 'There are no boxes added to the invoice. Please add at least one box.',
                            icon: 'warning',
                });
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
        var invoice_date = $.trim($('#invoice_date').val());
        var country = $.trim($('#country').val());
        var storeArray = $('#store').val(); // This
        
        var container_cost = $.trim($('#container_cost').val());
        var misc_cost = $.trim($('#misc_cost').val());
        var mb_no = $.trim($('#mb_no').val());
        if(invoice_date == '')
        {
            swalMessage('#invoice_date', 'Invoice Date');
            return false;
        }
        else if(country == '')
        {
            swalMessage('#country', 'Country');
            return false;
        }
        else if(storeArray.length === 0)
        {   
            swalMessage('#country', 'Store');
            return false;
        }
        else if(container_cost == '')
        {
            swalMessage('#container_cost', 'Container Cost');
            return false;
        }
        else if(misc_cost == '')
        {
            swalMessage('#misc_cost', 'Misc Cost');
            return false;
        }
        else if(mb_no == '')
        {
            swalMessage('#mb_no', 'MB No');
            return false;
        }
        else
        {
            $.ajax({
                url:'partials/update_temp_invoice_data.php',
                type: 'post',
                data: { 
                    invoice_date: invoice_date,
                    country: country,
                    store: storeArray,
                    container_cost: container_cost,
                    misc_cost: misc_cost,
                    mb_no: mb_no
                 },
                dataType:'json',
                beforeSend:function(){
                    $('#loader').show();
                },
                success:function(res){
                    if(res.msg == 'Success')
                    {
                        swal({
                            title: 'Success',
                            text: 'Invoice details updated successfully.',
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



});