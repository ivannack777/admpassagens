


    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="index.html">
                        <img class="align-content" src="/images/logo.png" alt="">
                    </a>
                </div>
                <div class="login-form">
                    <form action="/usuarios/login/entrar" method="post">
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="identificador" class="form-control" id="identificador" name="identificador" placeholder="E-mail ou celular ou usuário">
                        </div>
                        <div class="form-group">
                            <label>Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha">
                        </div>
                        <div class="checkbox">
                            <label>
                                <!-- <input type="checkbox"> Lembrar -->
                            </label>
                            <label class="pull-right">
                                <a href="/usuarios/resetsenha">Esqueceu a senha?</a>
                            </label>

                        </div>
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Entrar</button>
                        
                        <div class="register-link m-t-15 text-center">
                            <p>Não tem uma conta? <a href="/usuarios/registrar"> Cadastre-se aqui</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

