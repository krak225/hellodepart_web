<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
      .text-center{
        text-align: center;
      }
      .table{
        font-size: 10px;
      }
      .impression{
        float: right;
        font-size: 10px;
      }
      .compagnie{
        float: left;
        width: 140px;
        height: 50px;
      }
      .hellodepart{
        float: right;
        width: 140px;
      }
    </style>
  </head>
  <body>
    <p>
      <img src="{{ $compagnie_logo }}" class="compagnie">
      <img src="https://www.hellodepart.com/assets/images/hellodepart-logo.png" class="hellodepart">
    </p>
    <br><br>
    <hr>
    <center><h6>{{ $title }} {{ $trajet->trajet_depart }} -- {{ $trajet->trajet_arrive }} à la date du {{ $date }}</h6></center>
    <table class="table">
      <thead class="thead-light">
        <tr>
          <th>Numéro</th>
          <th>Nom & Prénoms</th>
          <th>Téléphone</th>
          <th>Destination</th>
          <th>Nbre Ticket</th>
          <th>Montant</th>
        </tr>
      </thead>
      <tbody>
        @foreach($ticketjours as $ticket)
          <tr>
            <td>{{ $ticket->client_code }}</td>
            <td>{{ $ticket->client_nom }} {{ $ticket->client_prenoms }}</td>
            <td>{{ $ticket->client_telephone }}</td>
            <td>{{ $ticket->ligne_designation }}</td>
            <td class="text-center">{{ $ticket->facture_nbr_ticket }}</td>
            <td>{{ number_format($ticket->facture_montant, 0, ',', ' ') }} FCFA</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <footer> 
      <p class="impression">Document imprimé le <?php echo(gmdate('Y-m-d H:i:s')) ?></p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    </body>
</html>