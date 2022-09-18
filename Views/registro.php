


    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="index.html">
                        <img class="align-content" src="/images/logo.png" alt="">
                    </a>
                </div>
                <div class="login-form">
                    <form action="/usuarios/registrar/salvar" method="post">
                        <div class="form-group">
                            <label>Usuário</label>
                            <input type="text" class="form-control" id="usuario" name="usuarios" placeholder="Nome de usuário">
                        </div>
                        <div class="form-group">
                            <label>E-mail </label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Endereço de e-mail">
                        </div>
                        <div class="form-group">
                            <label>Celular </label>
                            <input type="text" class="form-control" id="celular" name="celular" data-mask="00 00000-0000" placeholder="__ _____-____">
                        </div>

                        <div class="form-group">
                            <label>Senha</label>
                            <input type="password" class="form-control" placeholder="Senha">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"> Aceitar os termos e políticas
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Cadastar</button>

                        <div class="register-link m-t-15 text-center">
                            <p>Já tem uma conta? <a href="/usuarios/login/form"> Entre aqui</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


