<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8">
		<title>Facturer-App</title>
            @include('includes/css_assets')
      </head>
      <body class="login-page">
            <div class="login-header box-shadow">
                  <div class="container-fluid d-flex justify-content-between align-items-center">
                        <div class="brand-logo">
                              <a href="login.html">
                                    {{-- <img src="vendors/images/deskapp-logo.svg" alt=""> --}}
                                    <h4 style="color: #000033;">FACTURER APP</h4>
                              </a>
                        </div>
                  </div>
            </div>
            <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
                  <div class="container">
                        <div class="row align-items-center">
                              <div class="col-md-6 col-lg-7">
                                    <img src="vendors/images/login-page-img.png" alt="">
                              </div>
                              <div class="col-md-6 col-lg-5">
                                    <div class="login-box bg-white box-shadow border-radius-10">
                                          <div class="login-title">
                                                <h2 class="text-center text-primary">Connexion aux Boutiques Valto</h2>
                                          </div>
                                          <form action="{{url('connect')}}" method="POST">
                                                @csrf
                                                <div class="select-role">
                                                      <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn active">
                                                                  <input type="radio" name="options" id="admin">
                                                                  <div class="icon"><img src="vendors/images/briefcase.svg" class="svg" alt=""></div>
                                                                  <span>Je suis</span>
                                                                  Manager
                                                            </label>
                                                            <label class="btn">
                                                                  <input type="radio" name="options" id="user">
                                                                  <div class="icon"><img src="vendors/images/person.svg" class="svg" alt=""></div>
                                                                  <span>Je suis</span>
                                                                  Employé
                                                            </label>
                                                      </div>
                                                </div>
                                                <div class="input-group custom">
                                                      <input type="text" name="nom" class="form-control form-control-lg" placeholder="Nom complet">
                                                      <div class="input-group-append custom">
                                                            <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                                      </div>
                                                </div>
                                                <div class="input-group custom">
                                                      <input type="password" name="matricule" class="form-control form-control-lg" placeholder="">
                                                      <div class="input-group-append custom">
                                                            <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                                      </div>
                                                </div>
                                                <div class="row pb-30">
                                                      <div class="col-6">
                                                            <div class="custom-control custom-checkbox">
                                                                  <input type="checkbox" name="remember" class="custom-control-input" id="customCheck1">
                                                                  <label class="custom-control-label" for="customCheck1">Remember</label>
                                                            </div>
                                                      </div>
                                                      
                                                </div>
                                                <div class="row">
                                                      <div class="col-sm-12">
                                                            <div class="input-group mb-0">
                                                                  <button class="btn btn-primary btn-lg btn-block" type="submit">Connexion</button>
                                                            </div>
                                                      </div>
                                                </div>
                                          </form>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </body>
</html>