<!doctype html>
<html>
<head>
<style>
  #customers {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
    font-size: 8px;
  }

  #customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
  }

  #customers tr:nth-child(even){background-color: #f2f2f2;}

  #customers tr:hover {background-color: #ddd;}

  #customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #04AA6D;
    color: white;
  }

  .impression{
    float: right;
    font-size: 10px;
    font-style: italic;
  }
</style>
</head>
<body>
<img src="https://hellodepart.com/public/assets/images//hellodepart-logo.png" class="hellodepart">
<h4 style="text-align: center;">LISTE DES RESERVATIONS DU {{ \Carbon\Carbon::parse($date_depart)->format('d-m-Y')}} AU {{ \Carbon\Carbon::parse($date_fin)->format('d-m-Y')}}</h4>

<table id="customers">
  <tr>
    <th>Numéro</th>
    <th>Nom & Prénoms</th>
    <th>Téléphone</th>
    <th>Destination</th>
    <th>Nbre Ticket</th>
    <th>Montant</th>
    <th>Gains</th>
    <th>Statut</th>
    <th>Date Paiement</th>
  </tr>
  @foreach($factures as $facture)
    <tr>
      <td>{{ $facture->client_code }}</td>
      <td>{{ $facture->client_nom }} {{ $facture->client_prenoms }}</td>
      <td>{{ $facture->client_telephone }}</td>
      <td>{{ $facture->ligne_designation }}</td>
      <td class="text-center">{{ $facture->facture_nbr_ticket }}</td>
      <td>{{ number_format($facture->facture_montant_total, 0, ',', ' ') }} FCFA</td>
      <td>{{ number_format($facture->facture_partpdv, 0, ',', ' ') }} FCFA</td>
      <td>{{ $facture->facture_statut_paiement }}</td>
      <td>{{ \Carbon\Carbon::parse($facture->facture_date_paiement)->format('d-m-Y')}}</td>
    </tr>
  @endforeach
</table>
<footer>  
  <p class="impression">Document imprimé le <?php echo(gmdate('Y-m-d')) ?> à <?php echo(gmdate('H:i:s')) ?> sur <span style="color:blue">www.hellodepart.com</span></p>
</footer>
</body>
</html>