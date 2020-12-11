<script type="text/javascript">
$(document).ready(function() {
	fullScreen();
	$("#item-nav-01").after(`<li class="breadcrumb-item active">Ventas por Proyectos</li>`);

	var date = new Date();

	var anio1 = parseInt( date.getFullYear() );
	var anio2 = parseInt( date.getFullYear() ) - 1;
	var mes1 = parseInt( date.getMonth() + 1 );
	var mes2 = ( mes1==1 )?( 12 ):( mes1-1 );

	$("select#cmbMes1").prop("selectedIndex", mes1);
	$("select#cmbMes2").prop("selectedIndex", mes2);

	$("#lblMesActual").text( $("select#cmbMes2 option:selected").text() );
	$("#lblMesAntero").text( $("select#cmbMes1 option:selected").text() );
	
	data = {
		'anio1' : anio1,
		'anio2' : anio2,
		'mes1'	: mes1,
		'mes2'	: mes2
	}

	loadDataVTS(data)
})

$("#cmbMes1").change( function( event ) {
	$('#tblVtsProyectos thead tr:eq(0) th:eq(3)').html($("#cmbMes1 option:selected").text());
});

$("#cmbMes2").change( function( event ) {
	$('#tblVtsProyectos thead tr:eq(0) th:eq(2)').html($("#cmbMes2 option:selected").text());
});

$("#compararMeses").click( function() {
	var anio1 = parseInt( $("#cmbAnio option:selected").val() );
	var anio2 = parseInt( $("#cmbAnio option:selected").val() ) - 1;
	var mes1 = parseInt( $("#cmbMes1 option:selected").val() );
	var mes2 = parseInt( $("#cmbMes2 option:selected").val() );

	if (mes1<=mes2) {
		mensaje('No puede comparar el mes seleccionado con un mes superior o igual', 'error');
	}else {
		data = {
			'anio1' : anio1,
			'anio2' : anio2,
			'mes1'	: mes1,
			'mes2'	: mes2
		}
		loadDataVTS(data);
	}
})

function loadDataVTS(data) {
	$('.lblAnioActual').text( data['anio1'] );
	$('.lblAnioAnteri').text( data['anio2'] );

	$('#tblVtsProyectos').DataTable({
		'ajax':{
			'url':'dataVTS',
			'dataSrc': '',
			data: {
				'anio1' : data['anio1'],
				'mes1'	: data['mes1'],
				'anio2' : data['anio2'],
				'mes2'	: data['mes2']
			}
		},
		"destroy" : true,
		"aaSorting": [],
		"lengthMenu": [[30], [30]],
		"info":    false,
		"paging": false,
		"language": {
			"zeroRecords": "Cargando...",
			"emptyTable": "NO HAY DATOS DISPONIBLES",
			"search":     "BUSCAR"
		},
		'columns': [
			{"data": "groupColumn" },
			{"data": "nombre" },
			{"data": "ruta" },
			{"data": "zona" },
			{"data": "data.mes2.anioActual", render: $.fn.dataTable.render.number( ',', '.', 2 ) },
			{"data": "data.mes2.anioAnterior", render: $.fn.dataTable.render.number( ',', '.', 2 ) },
			{"data": null,
				render: function(data, type, row) { 
					var temp = (row.data.mes2.anioAnterior==0)?0:((row.data.mes2.anioActual /  row.data.mes2.anioAnterior)-1)*100;
					return $.fn.dataTable.render.number(',', '.', 0).display( temp )+'%'
				} 
			},
			{"data": "data.mes1.anioActual", render: $.fn.dataTable.render.number( ',', '.', 2 ) },
			{"data": "data.mes1.anioAnterior", render: $.fn.dataTable.render.number( ',', '.', 2 ) },
			{"data": null,
				render: function(data, type, row) { 
					var temp = (row.data.mes1.anioAnterior==0)?0:((row.data.mes1.anioActual /  row.data.mes1.anioAnterior)-1)*100;
					return $.fn.dataTable.render.number(',', '.', 0).display( temp )+'%'
				} 
			},
		],
		"columnDefs": [
			{ "visible": false, "targets": 0 },
			{ "width":"20%","targets":[1] },
			{ "width":"5%","targets":[4,5,6,7,8,9] },
			{ "className": "dt-center", "targets": [ 2 ]},
			{ "className": "dt-right", "targets": [ 4, 5, 6, 7, 8, 9 ]},
		],
		rowGroup: {
			dataSrc: 'groupColumn',
			startRender: null,
			endRender: function ( rows, group ) {
				var mes2_01 = rows
					.data()
					.pluck('data')
					.pluck('mes2')
					.pluck('anioActual')
					.reduce( function (a, b) {
						return a + b;
					}, 0);

				var mes2_02 = rows
					.data()
					.pluck('data')
					.pluck('mes2')
					.pluck('anioAnterior')
					.reduce( function (a, b) {
						return a + b;                        
					}, 0);

				var mes1_01 = rows
					.data()
					.pluck('data')
					.pluck('mes1')
					.pluck('anioActual')
					.reduce( function (a, b) {
						return a + b;
					}, 0);

				var mes1_02 = rows
					.data()
					.pluck('data')
					.pluck('mes1')
					.pluck('anioAnterior')
					.reduce( function (a, b) {
						return a + b;                        
					}, 0);

				crece01 = ( mes2_02==0 )?0:((mes2_01/mes2_02)-1)*100;
				crece02 = ( mes1_02==0 )?0:((mes1_01/mes1_02)-1)*100;

				mes2_01 = $.fn.dataTable.render.number(',', '.', 2).display( mes2_01 );
				mes2_02 = $.fn.dataTable.render.number(',', '.', 2).display( mes2_02 );
				mes1_01 = $.fn.dataTable.render.number(',', '.', 2).display( mes1_01 );
				mes1_02 = $.fn.dataTable.render.number(',', '.', 2).display( mes1_02 );

				crece01 = $.fn.dataTable.render.number(',', '.', 0).display( crece01 )+'%';
				crece02 = $.fn.dataTable.render.number(',', '.', 0).display( crece02 )+'%';

				return $('<tr/>')
				.append( `<td class="table-primary font-weight-bold" colspan="3">Total</td>` )
				.append( `<td class="dt-right table-primary font-weight-bold">`+mes2_01+`</td>` )
				.append( `<td class="dt-right table-primary font-weight-bold">`+mes2_02+`</td>` )
				.append( `<td class="dt-right table-primary font-weight-bold">`+crece01+`</td>` )
				.append( `<td class="dt-right table-primary font-weight-bold">`+mes1_01+`</td>` )
				.append( `<td class="dt-right table-primary font-weight-bold">`+mes1_02+`</td>` )
				.append( `<td class="dt-right table-primary font-weight-bold">`+crece02+`</td>` );
			}
		},
		"footerCallback": function ( row, data, start, end, display ) {
			var api = this.api(), data;
			var intVal = function ( i ) {
				return typeof i === 'string' ?
				i.replace(/[\C$,]/g, '')*1 :
				typeof i === 'number' ?
				i : 0;
			};

			total01 = api
			.column( 4 )
			.data()
			.reduce( function (a, b) {
				return intVal(a) + intVal(b);
			}, 0 );

			total02 = api
			.column( 5 )
			.data()
			.reduce( function (a, b) {
				return intVal(a) + intVal(b);
			}, 0 );			

			total03 = api
			.column( 7 )
			.data()
			.reduce( function (a, b) {
				return intVal(a) + intVal(b);
			}, 0 );

			total04 = api
			.column( 8 )
			.data()
			.reduce( function (a, b) {
				return intVal(a) + intVal(b);
			}, 0 );

			crece01_ = ( total02==0 )?0:((total01/total02)-1)*100;
			crece02_ = ( total04==0 )?0:((total03/total04)-1)*100;

			$( api.column( 4 ).footer() ).html(
				numeral(total01).format('0,0.00')
			);

			$( api.column( 5 ).footer() ).html(
				numeral(total02).format('0,0.00')
			);

			$( api.column( 6 ).footer() ).html(
				numeral(crece01_).format('0,0')+'%'
			);

			$( api.column( 7 ).footer() ).html(
				numeral(total03).format('0,0.00')
			);

			$( api.column( 8 ).footer() ).html(
				numeral(total04).format('0,0.00')
			);

			$( api.column( 9 ).footer() ).html(
				numeral(crece02_).format('0,0')+'%'
			);
		}
	});

	$('#tblVtsProyectos_length').hide();
	$('#tblVtsProyectos_filter').hide();
}
</script>

