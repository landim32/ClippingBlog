<div id="loginModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="max-width: 400px;" role="document">
        <div class="modal-content">
            <form class="form-horizontal" method="POST">
                <input type="hidden" name="ac" value="logar" />
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-user-circle"></i> Entre no Sistema</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <!--label class="col-md-3 control-label">Email:</label-->
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-fw fa-envelope"></i></span>
                                <input type="text" name="email" class="form-control" placeholder="Seu email" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <!--label class="col-md-3 control-label">Senha:</label-->
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>
                                <input type="password" name="senha" class="form-control" placeholder="Sua senha" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Fechar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Entrar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->