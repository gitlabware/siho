@if(isset($cliente))
    {!! Form::model($cliente, ['route' => ['guarda_cliente',$cliente->id], 'method' => 'post', 'files'=>true,'enctype' => 'multipart/form-data','id' => 'form-cliente']) !!}
@else
    {!! Form::open(['route' => ['guarda_cliente'], 'files'=>true,'id' => 'form-cliente']) !!}
@endif
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span>

    </button>
    <h4 class="modal-title">Formulario de Cliente</h4>
</div>

<div class="modal-body">


    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                {!! Form::label('nombre', 'Nombre:') !!}
                {!! Form::text('nombre', null, ['class' => 'form-control','required']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('nacionalidad', 'Nacionalidad:') !!}
                {!! Form::text('nacionalidad', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>


    <!-- Edad Field -->
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                {!! Form::label('edad', 'Edad:') !!}
                {!! Form::date('edad', $edad, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('procedencia', 'Procedencia:') !!}
                {!! Form::text('procedencia', null, ['class' => 'form-control']) !!}
            </div>
        </div>

    </div>


    <!-- Profesion Field -->
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                {!! Form::label('profesion', 'Profesion:') !!}
                {!! Form::text('profesion', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('pasaporte', 'Pasaporte:') !!}
                {!! Form::text('pasaporte', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                {!! Form::label('ci', 'Ci:') !!}
                {!! Form::text('ci', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('celular', 'Celular:') !!}
                {!! Form::text('celular', null, ['class' => 'form-control']) !!}
            </div>
        </div>

    </div>

    <!-- Referencia Field -->
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                {!! Form::label('referencia', 'Referencia:') !!}
                {!! Form::text('referencia', null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('direccion', 'Direccion:') !!}
                {!! Form::text('direccion', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>

    <!-- Observaciones Field -->
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                {!! Form::label('observaciones', 'Observaciones:') !!}
                {!! Form::text('observaciones', null, ['class' => 'form-control','style' => 'background: #f7e863;']) !!}
            </div>
        </div>
    </div>
    <div class="form-group" >
        <div class="row">
            <div class="col-md-8">
                <div class="row" id="adjunto-1">
                    <div class="col-md-4 text-right">
                        <b>ARCHIVO ADJUNTO 1</b>
                    </div>
                    <div class="col-md-8">
                        {!! Form::file('archivos[1][datos]') !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-success btn-sm" onclick="adicionar_a();"><i class="fa fa-plus"></i>
                    Adicionar
                </button>
                <button type="button" class="btn btn-danger btn-sm" onclick="quitar_a();"><i class="fa fa-minus"></i>
                    Quitar
                </button>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    @foreach($adjuntos as $adjunto)
                        <tr>
                            <td>{!! $adjunto->nombre_original !!}</td>
                            <td>
                                <a href="{!! url('adjuntos/'.$adjunto->nombre) !!}" target="_blank"
                                   class="btn btn-success btn-sm" title="Descargar adjunto"><i
                                            class="fa fa-download"></i></a>
                                <a href="javascript:"
                                   onclick="if(confirm('Esta seguro de eliminar el archivo adjunto??')){eliminar_adj({!! $adjunto->id !!});}"
                                   class="btn btn-danger btn-sm" title="Eliminar adjunto"><i
                                            class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
{!! Form::hidden('ruser_id',Auth::user()->id) !!}
<div class="modal-footer">
    {!! Form::submit('Guardar', ['class' => 'btn btn-outline pull-left']) !!}
    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
</div>
{!! Form::close() !!}


<script>
    var n_adj = 1;
    function adicionar_a() {
        n_adj++;
        var cont_adj = $('#adjunto-1').html();
        $('#adjunto-' + (n_adj - 1)).after('<div class="row" id="adjunto-' + n_adj + '">' + cont_adj + '</div>');
        $('#adjunto-' + n_adj + ' div.text-right b').html('ARCHIVO ADJUNTO ' + n_adj);
        $('#adjunto-' + n_adj + ' input').attr('name', 'archivos[' + n_adj + '][datos]');
    }
    function quitar_a() {
        if (n_adj != 1) {
            $('#adjunto-' + n_adj).remove();
            n_adj--;
        }
    }
    $("#form-cliente").submit(function (e) {
        var postData = new FormData($(this)[0]);
        //console.log($(this));


        //var postData = $(this).serializeArray();
        //console.log(postData);
        //console.log(postData2);
        //e.preventDefault();

        var formURL = $(this).attr("action");
        $.ajax(
                {
                    url: formURL,
                    type: "POST",
                    data: postData,
                    async: false,
                    processData: false,
                    cache: false,
                    contentType: false,

                    beforeSend: function (XMLHttpRequest) {
                        //alert("antes de enviar");
                        $('#divmodal').hide();
                        jQuery("#spin-cargando-mod").show(200);
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        //alert('despues de enviar');
                    },
                    success: function (data, textStatus, jqXHR) {
                        //console.log(data);
                        setTimeout(function () {
                            jQuery("#spin-cargando-mod").hide();
                            $('#divmodal').show();
                            if (data['m_error'] == '') {
                                $('#mimodal').attr('class', 'modal modal-success');
                                $('#divmodal h4.modal-title').html(data['m_bueno']);
                                $('#divmodal div.modal-body').hide();
                                $('#divmodal div.modal-footer').hide();
                                setTimeout(function () {
                                    $('#mimodal').modal('hide');
                                    recargatabla();
                                }, 1900);
                            } else {
                                $('#mimodal').attr('class', 'modal modal-danger');
                                $('#divmodal h4.modal-title').html(data['m_error']);
                                $('#divmodal div.modal-body').hide();
                                $('#divmodal div.modal-footer').hide();
                                setTimeout(function () {
                                    //$('#divmodal h4.modal-title').html('Formulario de Cliente');
                                    $('#divmodal div.modal-body').show();
                                    $('#divmodal div.modal-footer').show();
                                    //$('#mimodal').modal('hide');
                                    //recargatabla();
                                }, 1900);
                            }


                        }, 1000);

                        //data: return data from server
                        //$("#parte").html(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        //if fails
                        alert("error");
                    }
                });
        e.preventDefault(); //STOP default action
        //e.unbind(); //unbind. to stop multiple form submit.
    });
    @if(isset($cliente->id))
    function eliminar_adj(idAdjunto) {
        $.ajax(
                {
                    url: '{!! url('elimina_adjunto') !!}/' + idAdjunto,
                    type: "GET",
                    beforeSend: function (XMLHttpRequest) {
                        //alert("antes de enviar");
                        $('#divmodal').hide();
                        jQuery("#spin-cargando-mod").show(200);
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        //alert('despues de enviar');
                    },
                    success: function (data, textStatus, jqXHR) {
                        //console.log(data);
                        setTimeout(function () {
                            jQuery("#spin-cargando-mod").hide();
                            $('#divmodal').show();
                            if (data['m_error'] == '') {
                                $('#mimodal').attr('class', 'modal modal-success');
                                $('#divmodal h4.modal-title').html(data['m_bueno']);
                                $('#divmodal div.modal-body').hide();
                                $('#divmodal div.modal-footer').hide();
                                setTimeout(function () {
                                    cargarmodal('{!! route('cliente',[$cliente->id]) !!}', 'primary', 'lg');
                                    $('#mimodal').attr('class', 'modal modal-primary');
                                    $('#divmodal div.modal-body').show();
                                    $('#divmodal div.modal-footer').show();
                                }, 1900);
                            } else {
                                $('#mimodal').attr('class', 'modal modal-danger');
                                $('#divmodal h4.modal-title').html(data['m_error']);
                                $('#divmodal div.modal-body').hide();
                                $('#divmodal div.modal-footer').hide();
                                setTimeout(function () {
                                    //$('#divmodal h4.modal-title').html('Formulario de Cliente');
                                    $('#divmodal div.modal-body').show();
                                    $('#divmodal div.modal-footer').show();
                                    //$('#mimodal').modal('hide');
                                    //recargatabla();
                                }, 1900);
                            }


                        }, 1000);

                        //data: return data from server
                        //$("#parte").html(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        //if fails
                        alert("error");
                    }
                });
    }
    @endif
</script>
