<!DOCTYPE html>
<html>
   <head>
      <title>Laravel Twilio Send SMS Form - ScratchCode.io</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
   </head>
   <body>
      <div class="container mt-5">
         <div class="panel panel-primary">
            <div class="panel-heading">
               <h2>Laravel Twilio Send SMS Form - ScratchCode.io</h2>
            </div>
            <div class="panel-body">
               @if(session('success'))
                   <div class="alert alert-success alert-block">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <strong>{{ session('success') }}</strong>
                   </div>
               @endif
               @if(session('error'))
                   <div class="alert alert-danger alert-block">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <strong>{{ session('error') }}</strong>
                   </div>
               @endif
               <form action="{{ route('send.sms') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
 
                     <div class="col-md-12">
                        <div class="col-md-6 form-group">
                           <label>Numéro de téléphone</label>
                           <input type="text" name="numero" class="form-control"/>
                           @error('numero')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Le numéro de téléphone est obligatoire</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                           <button type="submit" class="btn btn-success">Envoyer le SMS</button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </body>
</html>