$(function() {
    fn_ListarClientes();

    $(document).on('click', '#btn-show-user-add', function(evt) {
        fn_ObtenerModalRegistrarCliente(function() {
            fn_LimpiarCliente();
            $('#modal-register-customer').modal('show');	
        });
    })

    $(document).on('click', '.btn-customer-edit-show', function(evt){     
        let clienteId =  $(this).data('cliente');
        let nroDocumento = $(this).data('clienteNro');
        fn_ObtenerModalRegistrarCliente(function() {
            fn_LimpiarCliente();
            $('#customerId_Add').val(clienteId);
            $('#nroDocumento_Add').val(nroDocumento);
            $('#nroDocumento_Add').data('valueOld', nroDocumento);
            fn_ObtenerCliente(function() {
                $('#modal-register-customer').modal('show');
            });
        })
    })

    $(document).on('dblclick', '#tbl_customers>tbody>tr', function() {
        let clienteId =  $(this).find('td:eq(1)').data('cliente');
        let nroDocumento = $(this).find('td:eq(1)').text();
        fn_ObtenerModalRegistrarCliente(function() {
            fn_LimpiarCliente();
            $('#customerId_Add').val(clienteId);
            $('#nroDocumento_Add').val(nroDocumento);
            $('#nroDocumento_Add').data('valueOld', nroDocumento);
            fn_ObtenerCliente(function() {
                $('#modal-register-customer').modal('show');
            });
        })
    })

})


function fn_ListarClientes() {
    tbl_clientes = $('#tbl_customers').DataTable({
        language: language_espanol,
        pageLength: 50,
        scrollX: true,
        orderCellsTop: true,
        fixedHeader: true,
        ajax: {
            method: "POST",
            url: "/cliente/listarJson"//,
            // data: function (d) {   }
            //$('#frmSaleSearch').serializeFormJSON()
        },
        columns: [
            {
                data: "clienteId", render: function (data, display, row) {
                    //console.log(data);  
                    //console.log(row);  
                    var str = "<div class='center' style='min-width:76px'>";
                    str += "<button type='button' class='btn btn-blue btn-xs btn-customer-edit-show' data-toggle='modal' data-target='#' data-cliente='" + data + "' data-cliente-nro='" + row.nro_documento+ "' ><i class='fa fa-edit'></i></button>";                    
                    str += "&nbsp;"
                    str += "<button type='button' class='btn btn-danger btn-xs btn-customer-delete' data-toggle='modal' data-target='#' data-cliente=" + data + "><i class='fa fa-trash-alt'></i></button>";                    
                    str += "</div>";
                    return str;
                }
            },
            // { data: "articuloId"},
            { data: "nro_documento" },
            { 
                data: "nombres", render: function(data, display, row){                    
                    return row.nombres + " " + row.apellido_paterno
                } 
            },
            { data: "telefono" },
            { data: "direccion" },
            { data: "email" },
            { data: "celular" }                
        ],
        createdRow: function (row, data, dataIndex, cells) {
            $(row).attr('tabindex', 0);
        }
    });
}
