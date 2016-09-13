<div class="modal modal-primary"  id="mimodal">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="col-md-12" id="spin-cargando-mod">
                <div class="box box-primary box-solid">
                    <div class="box-header">
                        <h3 class="box-title">Cargando</h3>
                    </div>
                    <!-- Loading (remove the following to stop the loading)-->
                    <div class="overlay">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <!-- end loading -->
                </div><!-- /.box -->
            </div><!-- /.col -->

            <div id="divmodal">

            </div>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@section('scripts')
    @parent
    <script>
        function cargarmodal(urll,color,largo)
        {
            if (color === undefined) {
                color = 'primary';
            }
            if (largo === undefined) {
                largo = 'md';
            }
            $('#mimodal').attr('class', 'modal modal-'+color);
            $('#mimodal div.modal-dialog').addClass('modal-'+largo);
            $('#divmodal').hide();
            jQuery("#spin-cargando-mod").show(200);
            jQuery('#mimodal').modal('show', {backdrop: 'static'});
            jQuery("#divmodal").load(urll, function (responseText, textStatus, req) {
                if (textStatus == "error")
                {
                    alert("error!!!");
                }
                else {
                    setTimeout(function ()
                    {
                        jQuery("#spin-cargando-mod").hide();
                        $('#divmodal').show();
                    }, 1500);

                }
            });

        }
    </script>
@endsection