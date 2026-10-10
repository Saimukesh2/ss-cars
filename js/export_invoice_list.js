$(function () {
    retrieveExportInvoiceList();
    //initalize datatable
    var dtExportInvoice =  $('#tblExportInvoiceList').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

    function retrieveExportInvoiceList() {
        $.ajax({
            url:'partials/get_export_invoice_list.php',
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
                        //Lets loop through the data and create a table row for each record and bind to datatable
                        dtExportInvoice.clear().draw();
                        var counter  = 1;
                        var measurement = '';
                        $.each(res.msg_detail, function(index, value) 
                        {
                            console.log(value.invoice_date);
                            // Assuming inward_date is in the format "yyyy-mm-dd"
                            var invoice_date = value.invoice_date;
                            // Convert the date string to a Date object
                            var dateObject = new Date(invoice_date);
                            // Format the date as "dd-mm-yyyy"
                            var formattedDate = dateObject.toLocaleDateString('en-IN', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            }).split('/').join('-');
                            dtExportInvoice.row.add([  
                                                    counter, 
                                                    value.invoice_no,
                                                    formattedDate,
                                                    value.country_code, 
                                                    value.location_names,
                                                    value.mb_no,
                                                    "<a href='view_export_invoice.php?id="+value.invoice_no+"'  class='badge badge-info' >View</a>", 
                                                    "<a href='edit_export_invoice.php?id="+value.invoice_no+"'  class='badge badge-warning' >Edit</a>", 
                                                    "<a href='excel_export_invoice.php?id="+value.invoice_no+"'  class='badge badge-success' >Excel</a>", 
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