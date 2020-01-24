<script>
$(document).ready(function() {
    var date    = new Date();
    var anio    = parseInt(date.getFullYear())
    var mes     = parseInt(date.getMonth()+1);

    

    var list_chk = {
                    'container-vm' : 'Ventas del mes',
                    'container-rm' : 'Recuperacion del mes',
                    'container-vb' : 'Valorización de Bodegas',
                    'container-tc' : 'Top 10 de Clientes',
                    'container-tp' : 'Top 10 de Productos' };

    var list_dash = '';

    //GUARDO VARIABLES EN COOKIES
    $(".content-graf .graf div").each(function() {
        name_class = $(this).attr('class');
        ( $.cookie( name_class )=='not_visible' || name_class=='container-vb' )?($('div.'+name_class).parent().hide()):($('div.'+name_class).parent().show());

        visibility = ( $.cookie( name_class )=='not_visible' )?'':'checked';

        if (name_class!='container-vb') {
            list_dash +=
            `<li class="">
              <div class="form-check">
                <input class="dash-opc form-check-input" type="checkbox" `+visibility+` value="`+name_class+`" id="`+name_class+`">
                <label class="form-check-label" for="`+name_class+`">
                  `+ ( list_chk[name_class] ) +`
                </label>
              </div>
            </li>`
        }
    });

    //AGREGO LA RUTA AL NAVEGADOR
    $("#item-nav-01").after(`<li class="breadcrumb-item active">Home</li>`);

    $("#content-dash").append(`
      <p class="font-weight-bold ml-2">Ver en Dashboard</p>
      <ul class="list-group list-group-flush mt-3">
        `+list_dash+`
      </ul>`);

    reordenandoPantalla();
    actualizandoGraficasDashboard(mes, anio)
    
    Highcharts.setOptions({
        lang: {
            numericSymbols: [ 'k' , 'M' , 'B' , 'T' , 'P' , 'E'],
            decimalPoint: '.',
            thousandsSep: ','
        }
    });

    ventas = {
        chart: {
            type: 'column',
            renderTo: 'grafVentas'
        },
        title: {
            text: 'Ventas del mes'
        },
        subtitle: {},
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            },
             stackLabels: {
            enabled: true
            }
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            series: {
                allowPointSelect: true,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                  formatter: function() {
                    if (this.y > 1000) {
                      //return Highcharts.numberFormat(this.y / 1000, 1) + "K";
                      return Highcharts.numberFormat(this.y);
                    } else {
                      return this.y
                    }
                  }
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">Ventas</span>',
            pointFormat: '<br><span style="color:{point.color}">{point.name}</span>: <b>C${point.y:,.2f}</b>',
            shared: true,
            useHTML: true
        },
        series:[{
            colorByPoint: true,
            colors: [
                '#90ed7d', 
                '#7cb5ec'
                ],
            data: [],
            showInLegend: false,
            cursor: 'pointer',
            point: {
                events: {
                    click: function(e) {
                        detalleVentasMes('vent', 'Ventas del Mes', 'data');
                    }
                }
            },
        }]    
    };

//Recuperacion del mes
/*
    Highcharts.chart('chart02', {

        chart: {
            type: 'column'
        },
        title: {
            text: 'Recuperacion del Mes'
        },
         xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                allowPointSelect: true,
                cursor: 'pointer',
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                  formatter: function() {
                    if (this.y > 1000) {
                      return Highcharts.numberFormat(this.y / 1000, 1) + "K";
                    } else {
                      return this.y
                    }
                  }
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>C${point.y:,.2f}</b>',
             shared: true,
            useHTML: true
        },
        series: [{
            states: {
                select: {
                    color: null
                }
            },
            cursor: 'pointer',
            point: {
                events: {
                    click: function() {
                        detalleVentasMes('recu', 'Recuperacion del Mes');
                    }
                }
            },
                name: "Recuperación",
                colorByPoint: true,
                data: [
                    {
                        name: "Real",
                        y: 11222.74,
                        drilldown: "Real"
                    },
                    {
                        name: "Meta",
                        y: 8929.43,
                        drilldown: "Meta"
                    },
                    
                ]
            }
        ]
        
    });*/

    recuperacionMes = {

       chart: {
            type: 'column',
            renderTo: 'grafRecupera'
        },
        title: {
            text: 'Recuperación del mes'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                allowPointSelect: true,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                  formatter: function() {
                    if (this.y > 1000) {
                      return Highcharts.numberFormat(this.y / 1000, 1) + "K";
                    } else {
                      return this.y
                    }
                  }
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">Ventas</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>C${point.y:,.2f}</b>',
            shared: true,
            useHTML: true
        },
        series:[{
            colorByPoint: true,
            data: [],
            showInLegend: false,
            cursor: 'pointer',
            point: {
                events: {
                    click: function(e) {
                        detalleVentasMes('recu', 'Recuperacion del Mes');
                    }
                }
            },
        }]
    };

 

    //GRAFICA: VALORIZACION DE INVENTARIO
    val_bodega = {
        chart: {
            type: 'column',
            renderTo: 'grafBodega'
        },
        title: {
            text: 'Valorización de Bodegas'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                allowPointSelect: true,
                
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                  formatter: function() {
                    if (this.y > 1000) {
                      return Highcharts.numberFormat(this.y / 1000, 1) + "K";
                    } else {
                      return this.y
                    }
                  }
                }
            }
        },
        tooltip: {
            pointFormat: '<span style="color:black"><b>C$ {point.y}</b></span>'
        },
        series:[{
            colorByPoint: true,
            data: [],
            showInLegend: false
        }]    
    };

    //GRAFICA: TOP 10 CLIENTES
    clientes = {
        chart: {
            type: 'column',
            renderTo: 'grafClientes'
        },
        title: {
            text: 'Top 10 Clientes'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                allowPointSelect: true,
                
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                  formatter: function() {
                    if (this.y > 1000) {
                      return Highcharts.numberFormat(this.y / 1000, 1) + "K";
                    } else {
                      return this.y
                    }
                  }
                }
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{point.color}"><b>C${point.y:,.2f}</b>',
        },
        series:[{
            colorByPoint: true,
            data: [],
            showInLegend: false
        }]        
    }

    //GRAFICA: TOP 10 PRODUCTOS
    productos = {
        chart: {
            type: 'column',
            renderTo: 'grafProductos'
        },
        title: {
            text: 'Top 10 Productos mas vendidos'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: ''
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                allowPointSelect: true,
                
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                  formatter: function() {
                    if (this.y > 1000) {
                      return Highcharts.numberFormat(this.y / 1000, 1) + "K";
                    } else {
                      return this.y
                    }
                  }
                }
            }
        },
        tooltip: {
            pointFormat: '<span style="color:black"><b>C$ {point.y}</b></span>'
        },
        series:[{
                colorByPoint: true,
                data: [],
                showInLegend: false
            }]        
    }

});


$("#filterM_A").click( function(e) {
    var mes = $('#opcMes option:selected').val();
    var anio = $('#opcAnio option:selected').val();
    actualizandoGraficasDashboard(mes,anio)
})

var val_bodega = {};
var clientes = {};
var ventas = {};
var recuperacionMes = {};
function actualizandoGraficasDashboard(mes, anio) {

    $("#grafClientes, #grafProductos, #grafVentas, #grafBodega, #grafRecupera")
    .empty()
    .append(`<div style="height:400px; background:#ffff; padding:20px">
                <div class="d-flex align-items-center">
                  <strong>Cargando...</strong>
                  <div class="spinner-border ml-auto text-primary" role="status" aria-hidden="true"></div>
                </div>
            </div>`);

    $.getJSON("dataGraf/"+mes+"/"+anio, function(json) {        
        var dta = [];
        var title = [];

        $.each(json, function (i, item) {

            switch (item['tipo']) {
                case 'dtaBodega':
                    dta = [];
                    title = [];
                    $.each(item['data'], function(i, x) {
                        dta.push({
                            name  : x['bodega'],
                            y     : x['data']
                        })

                        title.push(x['name'])
                    });

                    
                    val_bodega.xAxis.categories = title;
                    val_bodega.series[0].data = dta;
                    val_bodega.subtitle = 'Datos hasta la fecha';
                    chart = new Highcharts.Chart(val_bodega);

                break;
                case 'dtaCliente':
                    dta = [];
                    title = [];
                    $.each(item['data'], function(i, x) {
                        dta.push({
                            name  : x['cliente'],
                            y     : x['data']
                        })

                        title.push(x['name'])
                    });
                    
                    clientes.xAxis.categories = title;
                    clientes.series[0].data = dta;
                    chart = new Highcharts.Chart(clientes);

                break;
                case 'dtaProductos':
                    dta = [];
                    title = [];
                    $.each(item['data'], function(i, x) {
                        dta.push({
                            name  : x['articulo'],
                            y     : x['data']
                        })

                        title.push(x['name'])
                    });
                    
                    productos.xAxis.categories = title;
                    productos.series[0].data = dta;
                    chart = new Highcharts.Chart(productos);
                break;
                case 'dtaVentasMes':
                    dta = [];
                    title = [];
                    $.each(item['data'], function(i, x) {
                        dta.push({
                            name  : x['name'],
                            y     : x['data']
                        })

                        title.push(x['name'])
                    });

                    var real_ = dta[0]['y'];
                    var meta_ = json[3].data[1].data;
                    var remanente = 0;

                    var porcentaje = (meta_!=0)? (real_/meta_) * 100 :0;
                    remanente = (real_>meta_)? real_- meta_ :0;
                    porcentaje = numeral(porcentaje).format('0,0.00')+`% de 100%`;
                    
                    ventas.xAxis.categories = title;
                    if (remanente==0) {
                        
                        ventas.series.length = 1;
                        ventas.series[0].colors[0]="#90ed7d";
                        
                        ventas.series[0].data = dta;
                        
                    }else{
                        ventas.plotOptions.pointFormat= '<br><span style="color:{point.color}">{point.name}</span>: <b>C${point.y:,.2f}</b>'
                        
                        ventas.plotOptions.column = {
                                stacking: 'normal',
                                dataLabels: {
                                    enabled: false
                                }
                            };
                            ventas.series.push({
                                colorByPoint: true,
                                colors: [
                                    '#04B431', 
                                    '#7cb5ec'
                                    ],
                                data: [],
                                showInLegend: false,
                                cursor: 'pointer',
                                point: {
                                    events: {
                                        click: function(e) {
                                            detalleVentasMes('vent', 'Ventas del Mes', 'data');
                                        }
                                    }
                                },
                            });
                                            
                            dta[0]['y'] = dta[0]['y']-remanente;
                        ventas.series[1].data = dta;
                        ventas.series[0].colors[0]="#04B431";
                        ventas.series[1].colors[0]="#90ed7d";
                        ventas.series[0].data= [remanente,0];
                        
                    }
                    
                    ventas.subtitle = {text: porcentaje};
                    chart = new Highcharts.Chart(ventas);
                    $("#MontoMeta").text('C$ ' + numeral(json[3].data[1].data).format('0,0.00') )
                break;
                case 'dtaRecupera':
                    dta = [];
                    title = [];
                    $.each(item['data'], function(i, x) {
                        dta.push({
                            name  : x['name'],
                            y     : x['data']
                        })

                        title.push(x['name'])
                    });
                    
                    recuperacionMes.xAxis.categories = title;
                    recuperacionMes.series[0].data = dta;
                    chart = new Highcharts.Chart(recuperacionMes);
                    $("#MontoMeta").text('C$ ' + numeral(json[3].data[1].data).format('0,0.00') )
                break;
                default:
                alert('Ups... parece que ocurrio un error :(');
            }
        });
    });
}

function detalleVentasMes(tipo, title, data) {
    $('#title-page-tem').text(title);
    $("#page-details").toggleClass('active');
    mes = $("#opcMes option:selected").val();
    anio = $("#opcAnio option:selected").val();

    switch(tipo) {        
        case 'vent':
            $("#cjVentas").show();
            $("#cjRecuperacion").hide();
            $("#cjRutVentas").show();
            $("#dtVentas").dataTable({
                responsive: true,
                "autoWidth":false,
                "ajax":{
                    "url": "detalles/"+tipo+"/"+mes+"/"+anio,
                    'dataSrc': '',
                },
                "destroy" : true,
                "info":    false,
                "lengthMenu": [[5,10,20,50,-1], [20,30,50,100,"Todo"]],
                "language": {
                    "zeroRecords": "Cargando...",
                    "paginate": {
                        "first":      "Primera",
                        "last":       "Última ",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    },
                    "lengthMenu": "MOSTRAR _MENU_",
                    "emptyTable": "NO HAY DATOS DISPONIBLES",
                    "search":     "BUSCAR"
                },
                'columns': [
                    { "title": "Articulo",      "data": "ARTICULO" },
                    { "title": "Descripcion",   "data": "DESCRIPCION" },
                    { "title": "U/M",           "data": "U_MEDIDA" },
                    { "title": "Cantidad",      "data": "CANTIDAD" },
                    { "title": "Precio x ud.",  "data": "PRECIOUND" },
                    { "title": "Monto",         "data": "MONTO" }
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    total = api
                        .column( 5 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    $('#MontoReal').text('C$'+ numeral(total).format('0,0.00'));
                }
            });

            //Tabla Ventas del Mes por Ruta
            $("#dtTotalXRutaVent").dataTable({
                responsive: true,
                "autoWidth":false,
                "ajax":{
                    "url": "ruta/"+mes+"/"+anio,
                    'dataSrc': '',
                },
                "destroy" : true,
                "info":    false,
                "lengthMenu": [[8,10,20,50,-1], [20,30,50,100,"Todo"]],
                "language": {
                    "zeroRecords": "Cargando...",
                    "paginate": {
                        "first":      "Primera",
                        "last":       "Última ",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    },
                    "lengthMenu": "MOSTRAR _MENU_",
                    "emptyTable": "NO HAY DATOS DISPONIBLES",
                    "search":     "BUSCAR"
                },
                'columns': [
                    { "title": "Ruta",      "data": "RUTA" },
                    { "title": "Monto",   "data": "MONTO" },
                ],
                
            });
            $('#txtMontoReal').text('Total real ventas');

            //$('#MontoMeta').text('C$ 0.00')
            $('#txtMontoMeta').text('Total meta');

        break;
      case 'recu':
        $("#cjRecuperacion").show();
        $("#cjVentas").hide();
        $("#cjRutVentas").hide();
        $("#dtRecuperacion").dataTable({
            responsive: true,
            "autoWidth":false,
            "ajax":{
                "url": "detalles/"+tipo+"/"+mes+"/"+anio,
                'dataSrc': '',
            },
            "info":    false,
            "destroy" : true,
            "lengthMenu": [[5,10,20,50,-1], [20,30,50,100,"Todo"]],
            "language": {
                "zeroRecords": "Cargando...",
                "paginate": {
                    "first":      "Primera",
                    "last":       "Última ",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                },
                "lengthMenu": "MOSTRAR _MENU_",
                "emptyTable": "NO HAY DATOS DISPONIBLES",
                "search":     "BUSCAR"
            },
            'columns': [
                { "title": "Ruta",          "data": "RUTA" },
                { "title": "Nombre",        "data": "NOMBRE" },
                { "title": "Monto",         "data": "MONTO" },
                { "title": "Meta",          "data": "META" },
                { "title": "Efectividad",   "data": "EFEC" }
            ]
        })
        $('#MontoReal').text('C$ 5,000.00');
        $('#txtMontoReal').text('Total real recuperado');

        $('#MontoMeta').text('C$ 0,000.00')
        $('#txtMontoMeta').text('Total meta');
        break;
      default:
        mensaje("Ups... algo ha salido mal")
    }
    $("#dtVentas_length, #dtRecuperacion_length").hide();
    $("#dtVentas_filter, #dtRecuperacion_filter").hide();
    $("#dtTotalXRutaVent_filter, #dtTotalXRutaVent_length").hide();
}

$('#filterDtTemp').on( 'keyup', function () {
    var table = $('#dtVentas').DataTable();
    table.search(this.value).draw();
});

$( "#cantRowsDtTemp").change(function() {
    var table = $('#dtTemporal').DataTable();
    table.page.len(this.value).draw();
});

$(".active-page-details").click( function() {
    $("#page-details").toggleClass('active');
});

/*OCULTANDO GRAFICAS DASHBOARD*/
$(document).on('change', '.dash-opc', function(e) {
    val01 = $(this).val();

    if( $(this).prop('checked') ) {
        $.cookie( $(this).val() , 'yes_visible');
        $('div.'+val01).parent().show();
        $.removeCookie($(this).val());
    }else {
        $.cookie( $(this).val() , 'not_visible');
        $('div.'+val01).parent().hide();
    }
    location.reload();
});

function reordenandoPantalla() {
    var x = 0;
    $(".content-graf div.row").each(function(e) {
        var div01 = $(this).attr('id');
        $("#" + div01 + " div.graf").each(function() {
            ($(this).is(":visible"))?x++:x=x;            
        })

        cont = 12 / x;

        $( "#" + div01 + " div.graf" ).removeClass( "col-sm-*" ).addClass( "col-sm-"+cont );
        x=0;

    });
}

</script>