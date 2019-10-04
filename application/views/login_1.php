<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bienvenido</title>
        <link rel="shortcut icon" href="favicon.ico" />
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?= assets('css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= assets('css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= assets('css/custom_css/login.css') ?>" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
        <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="full-content-center">
                <div class="box bounceInLeft animated">
                    <video id="preview" width="200" height="200"></video>
                    <h3 class="text-center">Entrar</h3>
                    <div id="app"></div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="checking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bienvenido <span id="nombre"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img class="img-rounded" id="imgen">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><span id="num"></span></button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var x = 0;
            var tiempo;
            function contar() {
                $('#num').text(x);
                if (x == 10) {
                    clearInterval(tiempo);
                    $('#checking').modal("hide");
                }
            }

            var app = new Vue({
                el: '#app',
                data: {
                    scanner: null,
                    activeCameraId: null,
                    cameras: [],
                    scans: []
                },
                mounted: function () {
                    var self = this;
                    self.scanner = new Instascan.Scanner({video: document.getElementById('preview'), scanPeriod: 5});
                    self.scanner.addListener('scan', function (content, image) {
                        self.scans.unshift({date: +(Date.now()), content: content});
                        var last_scan = content.split(",");
                        console.log(last_scan);

                        $.ajax({
                            url: "<?= site_url('Admin/login_QR') ?>",
                            type: 'POST',
                            headers: {'Access-Control-Allow-Origin': 'http://127.0.0.1'},
                            dataType: 'JSON',
                            data: {
                                user: last_scan[0],
                                qr: last_scan[1],
                                tipo: last_scan[2]
                            },
                            success: function (resp) {

                                console.log(resp);

                                if (resp.success == '1') {
                                    console.log(resp.mensajes);
                                    $('#nombre').text(resp.mensajes.Nombre + ' ' + resp.mensajes.Apellidos);
                                    $('#imgen').attr('src', '<?= archivos() ?>' + resp.mensajes.Foto);
                                    $('#checking').modal("show");

                                    tiempo = setTimeout(contar(), 1000);

                                }
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                console.log(xhr, ajaxOptions, thrownError);
                            }
                        });

                    });
                    Instascan.Camera.getCameras().then(function (cameras) {
                        self.cameras = cameras;
                        if (cameras.length > 0) {
                            self.activeCameraId = cameras[0].id;
                            self.scanner.start(cameras[0]);
                        } else {
                            console.error('No cameras found.');
                        }
                    }).catch(function (e) {
                        console.error(e);
                    });
                },
                methods: {
                    formatName: function (name) {
                        return name || '(unknown)';
                    },
                    selectCamera: function (camera) {
                        this.activeCameraId = camera.id;
                        this.scanner.start(camera);
                    }
                }
            });
        </script>
        <script src="<?= assets('js/jquery.min.js') ?>" type="text/javascript"></script>
        <script src="<?= assets('js/bootstrap.min.js') ?>" type="text/javascript"></script>
    </body>
</html>
