    $(function () {
        $("#store").select2();

        $('#frmAddBox').validate({
            rules: {
                box_no: {
                    required: true
                },
                length: {
                    required: true,
                    number: true
                },
                width: {
                    required: true,
                    number: true
                },
                height: {
                    required: true,
                    number: true
                },
                weight: {
                    required: true,
                }
            },
            messages: {
                box_no: "Please enter box number",
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
            submitHandler: function(form) {
                var invoice_no = $('#invoice_no').val();
                $.ajax({
                    url: "partials/edit_invoice_add_box.php", // Replace with your PHP script to handle form submission
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
                            retrieveInvoiceData();

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
        // FOrm submit action
        $("#frmExportInvoice").validate({
            rules: {
                // Specify validation rules for form fields
                invoice_date: {
                    required: true
                },
                country: {
                    required: true
                },
                'store[]': {
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
                }
            },
           
            messages: {
                // Specify error messages for mandatory fields
                invoice_date: "Please enter invoice date",
                country: "Please select country",
                'store[]': "Please select store",
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
                    url: "partials/update_export_invoice.php", // Replace with your PHP script to handle form submission
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
                                text: "Invoice details updated successfully",
                                icon: 'success',
                            });
                            //retrieveBoxData();

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

        //Page load initialization to fetch already added items by the user
        retrieveInvoiceData();
        $("#invoice_date").datepicker({
            dateFormat: "dd-mm-yy ", // ISO format date
            changeMonth: true,
            changeYear: true
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
                            console.log(id);
                            $('#store option[value="' + id + '"]').prop('selected', true);
                        });
                    }

                }
            });
        }
        function retrieveInvoiceData()
        {
            var invoice_no = $("#invoice_no").val();
            $.ajax({
                url:'partials/get_export_invoice_data.php',
                type: 'post',
                data: {invoice_no: invoice_no},
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
                            var storeIds_csv =  res.msg_detail[0].location_gid;
                            
                            var container_cost = res.msg_detail[0].container_cost;
                            var misc_cost = res.msg_detail[0].misc_cost;
                            var mb_no = res.msg_detail[0].mb_no;
                            $('#invoice_date').val(formattedDate);
                            $('#invoice_no').val(invoice_no);
                            $('#country').val(country);
                            $('#container_cost').val(container_cost);
                            $('#misc_cost').val(misc_cost);
                            $('#mb_no').val(mb_no);
                            //$('#store').val(store);
                            var arrayFromCSV = storeIds_csv.split(',');
                            console.log(storeIds_csv);
                            populateStore(country,arrayFromCSV);
                            $('#export_invoice_no').text(invoice_no);
                            //Lets loop through the data and create a table row for each record and bind to datatable
                            dtAddedItems.clear().draw();
                            var counter  = 1;
                            var measurement = '';
                            $.each(res.msg_detail, function(index, value) {
                                measurement = "Length - "+value.box_length + " Width - "+value.box_width + " Height - "+value.box_height + " Weight - "+value.box_weight 
                                dtAddedItems.row.add([counter, value.box_no, measurement,value.misc_no,
                                                        "<a href='edit_tagged_products.php?id="+value.invoice_detail_gid+"' class='badge badge-warning tag-products'>Edit</a>"
                                                    ]).draw();
                                counter ++;
                            });
                        }
                    }
                },
                complete:function(){
                    $('#loader').hide();
                }
            });
        }

    });
        

        
