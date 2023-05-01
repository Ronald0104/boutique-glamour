<!-- Main content -->
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header page-header-light">

        <!-- Colocarlo en una seccion aparte -->
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/admin/empresa" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Admin</a>
                    <span class="breadcrumb-item active">Empresa</span>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

            <div class="header-elements d-none">
                <div class="breadcrumb justify-content-center">
                    <a href="#" class="breadcrumb-elements-item">
                        <i class="icon-comment-discussion mr-2"></i>
                        Ajustes
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">
        <div class="row">
            <div class="col-sm-9 col-md-8 col-lg-7">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title"><b>Empresa</b></h5>
                        <div class="group-button">
                            <button class="btn btn-dark btn-lg pull-right" id="btn-save-company"><i
                                    class="icon icon-floppy-disk"></i> &nbsp;Guardar</button>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <form action="" class="form-horizontal">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="nombreComercial" class="col-sm-4 col-md-3 col-form-label">Nombre
                                            Comercial :</label>
                                        <div class="col-sm-8 col-md-9">
                                            <input type="text" name="nombreComercial" id="nombreComercial"
                                                class="form-control" placeholder="Nombre Comercial">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="ruc" class="col-sm-4 col-md-3 col-form-label">N° RUC :</label>
                                        <div class="col-sm-5 col-md-4">
                                            <input type="text" name="ruc" id="ruc" class="form-control"
                                                placeholder="N° RUC">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="razonSocial" class="col-sm-4 col-md-3 col-form-label">Razón Social
                                            :</label>
                                        <div class="col-sm-8 col-md-9">
                                            <input type="text" name="razonSocial" id="razonSocial" class="form-control"
                                                placeholder="Razón Social">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="direccion" class="col-sm-4 col-md-3 col-form-label">Dirección
                                            :</label>
                                        <div class="col-sm-8 col-md-9">
                                            <input type="text" name="direccion" id="direccion" class="form-control"
                                                placeholder="Dirección">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="telefono" class="col-sm-4 col-md-3 col-form-label">Teléfono
                                            :</label>
                                        <div class="col-sm-6 col-md-5">
                                            <input type="text" name="telefono" id="telefono" class="form-control"
                                                placeholder="Teléfono">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="celular" class="col-sm-4 col-md-3 col-form-label">Celular
                                            :</label>
                                        <div class="col-sm-6 col-md-5">
                                            <input type="text" name="celular" id="celular" class="form-control"
                                                placeholder="Celular">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="paginaWeb" class="col-sm-4 col-md-3 col-form-label">Página Web
                                            :</label>
                                        <div class="col-sm-8 col-md-9">
                                            <input type="text" name="paginaWeb" id="paginaWeb" class="form-control"
                                                placeholder="Página Web">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="facebook" class="col-sm-4 col-md-3 col-form-label">Facebook
                                            :</label>
                                        <div class="col-sm-8 col-md-9">
                                            <input type="text" name="facebook" id="facebook" class="form-control"
                                                placeholder="Facebook">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="twitter" class="col-sm-4 col-md-3 col-form-label">Twitter
                                            :</label>
                                        <div class="col-sm-8 col-md-9">
                                            <input type="text" name="twitter" id="twitter" class="form-control"
                                                placeholder="Twitter">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="youtube" class="col-sm-4 col-md-3 col-form-label">You Tube
                                            :</label>
                                        <div class="col-sm-8 col-md-9">
                                            <input type="text" name="youtube" id="youtube" class="form-control"
                                                placeholder="YouTube">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- <div class="card-footer">
                        Footer
                    </div> -->
                </div>
            </div>
            <div class="col-sm-3 col-md-4 col-lg-5">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <!-- <h5 class="card-title"><b>Empresa</b></h5>
                        <div class="group-button">
                            <button class="btn btn-dark btn-lg pull-right" id="btn-save-company"><i
                                    class="icon icon-floppy-disk"></i> &nbsp;Guardar</button>
                        </div> -->
                    </div>
                    <div class="card-body pt-3">
                        <form action="" class="form-horizontal">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="tituloLogin" class="col-sm-4 col-form-label">Título Login :</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="tituloLogin" id="tituloLogin" class="form-control"
                                                placeholder="Título Login">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Upload Image</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <span class="btn btn-default btn-file">
                                                    Browse… <input type="file" id="imgInp">
                                                </span>
                                            </span>
                                            <input type="text" class="form-control" readonly>
                                        </div>
                                        <img id='img-upload' />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- /Content area -->

</div>
<!-- /Main Content -->