              <div class="row">
                <div class="col s12">
                  <ul class="tabs">
                    <li class="tab col s3"><a class="active" href="#test1"> Create Shoptag</a></li>
                    <li class="tab col s3"><a href="#test2" id="shoptag_admin">Shoptag Admin</a></li>
                  </ul>
                </div>
                <div id="test1" class="col s12">

                <h5>Create Shoptag - Please choose your language and your Country first!</h5>
              
                              <h5>1. Choose Language and Country</h5>

                                <div class="row">
                                        <div class="col s6">
                                          <select>
                                          <option value="" disabled selected>Choose your language</option>
                                          <option value="1">Deutsch</option>
                                          
                                          </select>
                                        </div>

                                        <div class="col s6">
                                            <select>
                                              <option value="" disabled selected>Choose your country:</option>
                                              <option value="1">Deutschland</option>
                                              <option value="2">Österreich</option>
                                              <option value="2">Schweiz</option>
                                            </select>
                                                         
                                        </div>
                                </div>

                              
                <br>
                                          

        <!-- Shoptag erstellen -->         
         <h5>2. Create Contag</h5>
        <div class="row">

        <form class="col s12" id="edit_form" method="POST">
          <?php include("forms/de_de.html"); ?>
        </form>
        </div>
        </div>

		      <!-- SHOPTAG: ADMIN -->
                      <div id="test2" class="col s12">
                         <h5 id="h5_home">Shoptag admin</h5>
                          <div class="row">

                          </div>
                      </div>
              </div>
