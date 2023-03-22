<style type="text/css">
  .invoice{
  max-width: 750px;
  width: 100%;
  min-width: 700px;
  //background: tomato;
  border: 1px solid black;
  font-size: 16px;
  padding: 12px;
  font-family:'Courier New', Courier, monospace;
  margin: 1rem auto;
  .separator{
      margin: 10px 0;
    text-align: center;
    p{
      margin: 0;
    }
  }
  .page-header{
    // Title
    .page-header__title{
        text-align: center;
      h1{
        font-size: 1.5em;
      }
    }
    //Nit
    .page-header__adres, .page-header__store, .page-header__nit{
      text-align: center;
      margin-bottom: 2px;
      h2{
        font-size: 1em;
        margin: 0;
        line-height: 1;
        span{
          font-size: 1em;
        }
      }
    }
  }
  
  .page-info{
    .item__page-info{
     p{
        font-size: 0.9em;
        margin: 0;
        line-height: 1.3;
        span{
          font-size: 1em;
        }
      }
    }
  }
  
  .page-data{
    .item__page-info{
      p{
        margin: 0;
        font-size: 0.9em;
        line-height: 1.2;
        span{
          font-size: 1em;
        }
      }
    }
  }
  
  .page-description{
    thead{
      th{
        font-size: 0.9em
      }
    }
    tbody{
      tr{
        td{
          font-size: 0.9em;
          p{
            margin: 0;
            font-size: 0.9em;
            line-height: 1.3;
          }
        }
      }
    }
  }
  
  .page-warranty{
    .item__page-info{
      p{
        margin: 0;
        text-align: center;
        font-size: 0.9em;
        line-height:1.2;
      }
      &.item__page-info--title{
        p{
          font-size: 1.1em;
        }
      }
    }
  }
  
  .page-raisedThirdParties{
    .page-raisedThirdParties__title{
   text-align: center;
      h1{
       font-size: 1em;
      }
      h2{
         font-size: 1em;
      }
    }
  }
}
table {
  font-family: 'Courier New', Courier, monospace;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<div class="invoice">
    <!--  header  -->
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="page-header__title">
                    <h1>TICKET D'EMBARQUEMENT</h1>
                </div>
                <div class="page-header__nit">
                    <h2><span>N°: </span>{{ $client->client_code }}</h2>
                </div>
                <div class="page-header__store">
                    <h2><span>Date de départ : </span>{{ \Carbon\Carbon::parse($client->client_datedepart)->format('d-m-Y') }}</h2>
                    <h2><span>Heure de départ : </span>{{ $client->client_heuredepart }}</h2>
                    <h2><span>Nom & Prénom : </span>{{ $client->client_nom }} {{ $client->client_prenoms }}</h2>
                    <h2><span>Gare d'embarquement : </span>{{ $information->gare_designation }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="separator">
        <p>**************************************************************</p>
    </div>

    <!--  Info  -->
    <div class="row">
        <div class="col-12">
            <div class="page-info">
                <div class="item__page-info">
                    <img src="https://www.hellodepart.com/assets/images/hellodepart-logo.png" width="100"><br>
                    <small>
                      sales@hellodepart.com <br>
                      +225 056 545 5642
                    </small>
                </div>
                <hr>
                <div class="item__page-info">
                    <img src="{{ $compagnie_logo }}" width="100" alt="{{ $information->compagnie_designation }}">
                    <p>{{ $information->compagnie_designation }}</p>
                    <small>
                      {{ $information->compagnie_email }}<br>
                      +225 {{ $information->compagnie_mobile }}<br>
                      {{ $information->compagnie_adresse_siege }}
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="separator">
        <p>**************************************************************</p>
    </div>   
    <!--  table  -->
    <div class="row">
        <div class="col-12">
          <div class="page-description">
            <table class="table table-sm">
            <thead>
              <tr>
                <th>DESCRIPTION</th>
                <th>TICKET</th>
                <th>PRIX</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{$information->ligne_designation }}</td>
                <td>{{ $client->client_nbreplace }}</td>
                <td>{{ number_format($client->client_prixunitaire, 0, ',', ' ') }} FCFA</td>
              </tr>
              <tr>
                <td colspan="2">MONTANT HT</td>
                <td class="text-right">
                  @php
                    $montantht = $client->client_prixunitaire * $client->client_nbreplace;
                    echo number_format($montantht, 0, ',', ' ').' FCFA';
                  @endphp
                </td>
              </tr>
              <tr>
                <td colspan="2">FRAIS</td>
                <td class="text-right">{{ number_format($facture->facture_frais, 0, ',', ' ') }} FCFA</td>
              </tr>
              <tr>
                <td colspan="2">TIMBRE D'ÉTAT</td>
                <td class="text-right">100 FCFA</td>
              </tr>
              <tr style="font-weight: bold;">
                <td colspan="2">MONTANT TOTAL</td>
                <td class="text-right">{{ number_format($facture->facture_montant, 0, ',', ' ') }} FCFA</td>
              </tr>
            </tbody>
          </table>
          </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="page-raisedThirdParties">
                <div class="page-raisedThirdParties__title">
                    <h3>Dieu vous accompagne, très bon voyage et à très bientôt !!!</h3>
                </div>
            </div>
        </div>
    </div>
</div>