<html>
<head>
  <meta name="format-detection" content="telephone=no" />
<meta name="viewport" content="width=device-width" initial scale=1>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600,400,300' rel='stylesheet' type='text/css'>

<style>
    body {
  margin: 0;
  padding: 0;
  background: #ddd;
  font-family: "Open Sans";
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-rendering: optimizeLegibility;
  font-size: 18px;
  color: #152E48;
  line-height: 26px;
  font-weight: 400;
}

.mail--body {
  background: #ddd;
  width: 100%;
}

td {
  padding: 0;
}

.mail--logo-container {
  padding: 0;
  padding-top: 10px;
  padding-right: 10px;
  vertical-align: top;
  text-align: right;
}

.mail--header-container {
  height: 348px;
  padding: 0;
  margin: 0 auto;
  max-width: 575px;
  background: #13466a;
  color: white;
  font-weight: 300;
  width: 575px;
}

.mail--header-column {
  margin-bottom: 24px;
}

.mail--main-container {
  margin: 0 auto;
  padding: 38px 25px 15px;
  width: 575px;
  background: white;
}

.mail--ad-container {
    width: 575px;
    margin: 0 auto;
  border-collapse: collapse;
  background: white;
}

.mail--content {
  padding: 0 0 30px;
}

.mail--content__main {
  border-bottom: 2px solid #ff7c3d;
}

.mail--content > * + * {
  margin-top: 20px;
}


.mail--secondary-content > * + * {
  margin-top: 24px;
}

.mail--ad-box {
  background: rgba(0, 150, 170, 0.4);
  padding: 25px 34px 25px;
  color: rgba(21,46,72,1);
}

.mail--row {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.mail--row > * + * {
  margin-left: 25px;
}

.mail--grow {
  table-layout: fixed;
  width: 100%;
  border-bottom: 2px solid #ff7c3d;
  padding-bottom: 15px;
}

.mail--grow > tbody > tr {
  height: 69px;
}

.mail--grow__short {
  width: 15%;
}

.mail--grow__long {
  width: 85%;
}

  .mail--row__border {
    border-top: 2px solid #ff7c3d;
    padding-bottom: 0px;
    padding-top: px;
  }

.mail--row__smaller {
  padding-right: 0;
}

.mail--h1 {
  margin: 0;
  font-size: 25px;
  line-height: 52px;
  font-weight: 300;
  margin-bottom: 6px;
  text-align:center !important;
  color: #152E48;
}

.mail--h2 {
  margin: 0;
  font-size: 20px;
  line-height: 24px;
  font-weight: 600;
  color: #152E48;
}

.mail--h3 {
  margin: 0;
  font-size: 18px;
  line-height: 26px;
  color: #152E48;
}

.mail--h3__blue {
  color: rgba(21,46,72,1);
  font-weight: 700;
  margin-bottom: 6px;
}

.mail--paragraph {
  padding: 0;
  line-height: 26px;
  margin-top: 12px;
  margin-bottom: 12px;
  color: #152E48;
}
  
.mail--paragraph__top {
  padding: 0;
  line-height: 26px;
  padding-bottom: 10px;
  color: #152E48;
}

.mail--paragraph__smaller {
  margin: 0;
  padding: 0;
  font-size: 16px;
  line-height: 23px;
  color: rgba(21,46,72,1);
}

.mail--aukakronurIcon {
  margin-right: 20px;
}

.mail--button {
  margin-top: 20px;
  text-align: center;
}

.mail--button:hover {
  opacity: 0.95;
}

.mail--button:active {
  opacity: 0.8;
}

.mail--logo__pleasework {
  padding-top: 8px;
}

.mail--rafr-skilriki {
  padding-top: 14px;
}

.mail--footer {
  font-size: 14px;
  font-weight: 600;
  margin-top: 30px;
  width: 100%;
}

.mail--footer td:last-child {
  text-align: right;
}

  
.mail--footer td:nth-child(2) {
  text-align: center;
}

.mail--link {
  all: unset;
  cursor: pointer;
}

.mail--link:hover {
  opacity: 0.8;
}

.mail--link:active {
  opacity: 0.5;
}

.mail--bold {
  font-weight: 600;
}

.mail--content > .mail--paragraph__main + * {
  margin-top: 36px;
}

.mail--secondary-content {
  padding-top: 8px;
}

.mail--secondary-content > .mail--ad-box + * {
  margin-top: 66px;
}

.mail--row > .mail--paragraph__smaller {
  margin-left: 30px;
}

.svg {
  height: 35px;
  width: 35px;
  flex-shrink: 0;
}

.no-circle {
  margin-top: 6px;
}

.lightBlueFill {
  fill: hsla(200, 74%, 60%, 1);
}

.greyFill {
  fill: hsla(212, 50%, 41%, 0.05);
}

.whiteFill {
  fill: #fff;
}

.whiteStroke {
  fill: none;
  stroke: #fff;
  stroke-miterlimit: 10;
}

.blueFill {
  fill: hsla(212, 50%, 41%, 1);
}

.blueStroke {
  fill: none;
  stroke-miterlimit: 10;
  stroke: hsla(212, 50%, 41%, 1);
}

.blueStrokeWhiteFill {
  stroke-miterlimit: 10;
  stroke: hsla(212, 50%, 41%, 1);
  fill: #fff;
}

.whiteStrokeWithLinecap {
  fill: none;
  stroke: #fff;
  stroke-miterlimit: 10;
  stroke-linecap: round;
}

.blueStrokeWithLinecap {
  fill: none;
  stroke-miterlimit: 10;
  stroke-linecap: round;
  stroke: hsla(212, 50%, 41%, 1);
}

.lightBlueStrokeWithLinecap {
  fill: none;
  stroke-miterlimit: 10;
  stroke-linecap: round;
  stroke: hsla(200, 74%, 60%, 1);
}

.whiteStrokeThicker {
  cfill: none;
  stroke: #fff;
  stroke-miterlimit: 10;
  stroke-width: 2;
}

.aukakronurIcon {
  width: 290px;
  padding-left: 10px;
}

@media only screen and (max-width: 420px) {  
  .mail--ad-box {
    padding-left: 25px;
    padding-right: 25px;
  }
}

.nom_client, .titre_info{
  text-transform:uppercase !important;
}

.nom_client{
  font-weight: bold !important;
}

</style>


  </head>
<body>
  <table class='mail--body'>
    <table class='mail--header-container'>
      <tr>
        <td class='mail--logo-container'>
          <img src="https://www.hellodepart.com/assets/images/hellodepart-logo.png" alt='logo' style="width: 200px !important;">
        </td>
      </tr>
    </table>
    <table class='mail--main-container'>
      <tr class='mail--header-column mail--grow'>
        <td class='mail--h1'>Votre paiement sur <a href="https://hellodepart.com/">hellodepart.com</a></td>
      </tr>
      <tr>
        <td>
          <p class='mail--paragraph__top mail--paragraph__main'>
            Bonjour <span class="nom_client">{{ $nom }} {{ $prenoms }}</span>,<br/> 
			Votre paiement a bel et bien été prise en compte dans notre système.
          </p>
        </td>
      </tr> 
    </table>
      
    <table class='mail--main-container mail--secondary-content '>
      <tr>
        <td class="mail--row__border">
          <h3 class='mail--h3 titre_info'>Voici le récapitulatif de votre paiement :</h3>
        </td>
      </tr>
      <tr>
        <td>
          <p class='mail--paragraph'>
            <ul>
              <li>Montant : {{ $amount }} {{ $currency }}</li>
              <li>Numéro de transaction : {{ $transaction_id }}</li>
              <li>Numéro d'embarquement : {{ $codeembarquement }}</li>
              <li>Date de paiement : {{ $transaction_date }}</li>      
              <li>Moyen de paiement : CINETPAY</li>      
            </ul>
          </p>
        </td>
      </tr>
      <tr>
        <td>
          <p class='mail--paragraph'>Toute l'équipe de HELLODEPART vous remercie et reste à votre disposition pour toute information utile.</b></p>
        </td>
      </tr>
    </table>
      
    <table class='mail--main-container mail--secondary-content '>
      <tr>
        <td class="mail--row__border">
          <h3 class='mail--h3 titre_info'>Le Service Commercial HELLODEPART</h3>
        </td>
      </tr>
      <tr>
        <td>
          <p class='mail--paragraph' style="margin-bottom: -10px;">
            +(255)071 135 6877
          </p>
          <p class='mail--paragraph' style="margin-bottom: -10px;">
            <a href="mailto:sales@hellodepart.com">sales@hellodepart.com</a>
          </p>
          <p class='mail--paragraph' style="margin-bottom: -10px;">
            <a href="https://www.hellodepart.com">https://www.hellodepart.com</a>
          </p>
        </td>
      </tr>
    </table>
    <table class='mail--main-container' style="padding-top: 10px; text-align: center;">
      <tr>
        <td class="mail--row__border">
          <p style="margin-top: 15px;"><?php echo gmdate("Y"); ?> HELLODEPART - Tous droits réservés.</p>
        </td>
      </tr>
    </table>
  </table>
</body>

</html>