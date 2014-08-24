<?php
/**
 *=============================================
 * REDAXO-Modul: do form!
 * Bereich: Eingabe 
 */
$doformversion="5.0";
 /**
 * ab Redaxo Version: 4.5
 * Module-id: 572
 * Werbeagentur KLXM Crossmedia  
 * www.klxm.de
 * Hinweise:
 * 
 * Formulargenerator für PHPMAILER
 * Required Addons: TinyMCE, PHPMAiler
 * 
 * Datum: 22.08.2014
 * Ursprung: Formular-Generator Redaxo 3.2 Demo, do form! 2
 * Typ: Modifikation / Erweiterung  
 *=============================================
 * 
 * VALUE[1] - E-Mail geht an 
 * VALUE[2] - (Ihre) Absenderadresse fuer die Bestaetigungs-E-Mail 
 * VALUE[3] - Formularfelder 
 * VALUE[4] - Betreff 
 * VALUE[5] - E-Mail-Bestaetigungstext 
 * VALUE[6] - TinyMCE 
 * VALUE[7] - Bezeichnung fuer Senden-Button 
 * VALUE[8] - Absender-Name 
 * VALUE[9] -  frei
 * VALUE[10] - Soll eine Bestaetigungs-E-Mail erstellt werden? 
 * VALUE[11] - BCC an 
 * VALUE[12] - HTML-EMAIL JA /NEIN
 * VALUE[13] - Original anhaengen? JA / NEIN
 * VALUE[14] - Uploadordner
 * VALUE[15] - Upload als Mail versenden
 * VALUE[16] - Bezeichner der Session-Variable
 * VALUE[17] - Bestätigungsbetreff
 * VALUE[18] - SSL-Schalter (JA/NEIN)
 * VALUE[19] - frei
 * VALUE[20] - frei
 * REX_FILE[1] - Dateianhang an Absender (z.B. AGB) 
 * 
 */
// EINGABE EINSTELLUNGEN
// zur Vereinfachung der Eingabemaske
// Erweiterte Funktionen in der Moduleingabe freischalten 
// Es sind evtl. Anpassungen im ausgabe-Code erforderlich
 
$uploadon=false;  // UPLOADS AKTIVIEREN true oder false
$sessionson=false;  // SESSIONS AKTIVIEREN true oder false
$bccon=false;  // BCC AKTIVIEREN true oder false
$sslon=false; // SSL-Umschalter - Muss in der Ausgabe angepasst werden 
$weditor='ckeditor'; // Welches WYSIWYG-addon soll verwendet werden? z.B.: ckeditor oder tinymce 
$editstyle='ckeditor'; // Lege die CSS-Klasse für den WYSIWYG-Editor fest (z.B. ckeditor oder tinyMCEEditor) 

 
// Definition des Standard-Formulars 
$defaultdata="
text|Nachname|1|||name
text|Vorname|1|||checkfield
text|Firma |
text|Straße|
text|PLZ|1|||plz
text|Ort|1|||
text|Telefon||||tel
text|Telefax||||tel
email|E-Mail|1|||sender
textarea|Ihre Nachricht: |1|
info|Geben Sie bitte noch mal Ihren Ihren Vornamen ein
text|Vorname|1|||check
";
 
 
 
/**
 * Convert a shorthand byte value from a PHP configuration directive to an integer value
 * @param    string   $value
 * @return   int
 */
if (!function_exists('convertBytes')) {
function convertBytes( $value ) {
    if ( is_numeric( $value ) ) {
        return $value;
    } else {
      $value = trim ($value);
      $value_length = strlen( $value );
      $qty = substr( $value, 0, $value_length - 1 );
      $unit = strtolower( substr( $value, $value_length - 1 ) );
      switch ( $unit ) {
          case 'g':
              $qty *= 1024;
          case 'm':
              $qty *= 1024;
          case 'k':
              $qty *= 1024;
      }
      return $qty;
    }
}
}
?>
 
<style type="text/css">
<!--
.formgenheadline {
	color: #006;
	display: block;
	padding-left: 10px;
	font-family: Tahoma, Geneva, sans-serif;
	padding-top: 2px;
	padding-right: 2px;
	padding-bottom: 2px;
	font-weight: 300;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 3px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	font-style: normal;
	background-color: #DFE9E9;
	background-position: bottom;
	font-size: 1.6em;
}
.doform {
	background-color: #eee;
	padding-left: 1.2em;
	padding-bottom: 1.2em;
	font-family: Tahoma, Geneva, sans-serif;
}
.doleft {
        float: left;
        width: 240px;
        background-color: #FFF;
        margin-right: 1.2em;
        margin-top: 1.2em;
        padding: 0.5em;
        border: 1px solid #999;
}
.doform  .inp100 {
        background-color: #eeeeee;
        border: 1px solid #CCC;
}
 
.formbg {
        background-color:#E0E2E8;
}
 
.formgenerror {
  color: #FFFFFF;
  background-color: #990000;
  border: 6px dashed #FFCC00;
  margin: 5px;
  padding: 5px;
}
.formgen_manual {
  color: #333333;
  font-size: 1.2em;
  background-color: #eeeeee;
}
.formgenconfig {
	background-color: #FFF;
	font-family: "Courier New", Courier, monospace;
	color: #006;
	font-size: 1.2em;
	width: 95%;
	margin-right: 2em;
	height: 250px;
	border: 1px solid #3C9ED0;
	overflow: auto;
}
.formgen_sample {
        background-color: #FFF;
        font-family: "Courier New", Courier, monospace;
        color: #333333;
        font-size: 1.2em;
        width: 95%;
        border: 1px solid #999;
}
.formgenalias {
	color: #CCCCCC;
	font-size: 0.9em;
}
#formgenblock {
  width: 540px;
  padding: 10px;
}
.infotext {
	color: #999999;
	font-style: italic;
	font-size: 0.9em;
}
.formgentitle {
        color: #6E97C1;
        background-color: #F1F1F1;
        display: block;
        padding-left: 10px;
        font-family: Geneva, Arial, Helvetica, sans-serif;
        padding-top: 2px;
        padding-right: 2px;
        padding-bottom: 2px;
        font-weight: bolder;
        border-top-width: 1px;
        border-right-width: 1px;
        border-bottom-width: 3px;
        border-left-width: 1px;
        border-top-style: solid;
        border-right-style: solid;
        border-bottom-style: solid;
        border-left-style: solid;
        border-top-color: #CCCCCC;
        border-right-color: #333333;
        border-bottom-color: #999;
        border-left-color: #666666;
        font-style: italic;
        font-size: 20px;
        margin-bottom: 6px;
}
.infotext2 {
        color: #37D749;
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
}
 
.myDivs .formgenheadline {
	background-color: #3C9ED0;
	color: #FFF;
}
.formnavi {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	background-color: #3C9ED0;
	padding-top: 4px;
	padding-right: 10px;
	padding-bottom: 15px;
	padding-left: 10px;
	color: #DFE7DF;
}
.formnavi a {
        border-bottom-width: 3px;
        border-bottom-style: solid;
        border-bottom-color: #333;
        padding: 0.3em;
        color: #FFF;
        font-weight: bold;
        text-decoration: none;
        margin-right: 0.5em;
        font-family: Tahoma, Geneva, sans-serif;
        margin-left: 0em;
        font-size: 1.2em;
}
.doleftdoc {
        float: left;
        width: 120px;
        background-color: #FFF;
        margin-right: 1.2em;
        margin-top: 1.2em;
        padding: 0.5em;
        border: 1px solid #999;
}
.doleftdoc2 {
        float: left;
        width: 420px;
        background-color: #FFF;
        margin-right: 1.2em;
        margin-top: 1.2em;
        padding: 0.5em;
        border: 1px solid #999;
}
.formnavi a:hover {
        border-bottom-width: 3px;
        border-bottom-style: solid;
        border-bottom-color: #93BB3D;
        padding: 0.3em;
        color: #FFC;
        font-weight: bold;
        text-decoration: none;
        margin-right: 0.5em;
        font-family: Tahoma, Geneva, sans-serif;
        margin-left: 0em;
        font-size: 1.2em;
}
 
 
-->
</style>
 
<script language="JavaScript" type="text/javascript"> 
<!-- 
function doIt(theValue) 
{ 
    var divs=document.getElementsByTagName("DIV"); 
    for (var i=0;i<divs.length;i++) 
    { 
        if (divs[i].className=="myDivs") 
        { 
        divs[i].style.display=(( theValue=="every" || divs[i].id==theValue)?"block":"none"); 
        }; 
    } 
} 
//--> 
</script>
 
 
<div class="formnavi"><a href="https://github.com/skerbis/do-form-5/wiki" target="_blank">WIKI</a><a href="#anleitung" id="anzeige" onclick="javascript:document.getElementById('anleitung').style.display = 'block'" >Beispiel-einblenden </a> do form! - Version: <?php echo $doformversion; ?>&nbsp;|   <?php echo $REX['LANG']; ?></div>
<br/><?php $phpmcheck= OOAddon::isActivated('phpmailer'); 
if ($phpmcheck == 1)
{}
else { echo' <div class="formgenerror"> PHPMailer wurde nicht gefunden oder ist nicht aktiviert. <br/> Bitte installieren Sie das ADDON! </div>'; }
?>
<div class="formgenheadline"> Formularfelder</div>
<div class="doform" clas="doform">typ|label|pflicht|default|value/s|validierung <br/>
  <textarea name="VALUE[3]" class="formgenconfig"><?php if ("REX_VALUE[3]" == '') {echo $defaultdata;} else {echo "REX_VALUE[3]";}  ?>
  </textarea>
</div>
<br />
<br />
 <div class="formgenheadline">Versandeinstellungen</div>
<div class="doform">
  <div class="doleft"><strong>Betreff:</strong><br />
      <input type="text" name="VALUE[4]" value="REX_VALUE[4]" class="inp100" />
     <br />
    <strong>Bezeichnung f&uuml;r Senden-Button:</strong><br />
      <input type="text" name="VALUE[7]" value="REX_VALUE[7]" class="inp100" />
      <br />
      <br />
    HTML-MAIL<span class="infotext"> 
<select   name="VALUE[12]">
  <option value='ja' <?php if ("REX_VALUE[12]" == 'ja') echo 'selected'; ?>>ja</option>
  <option value='nein' <?php if ("REX_VALUE[12]" == 'nein') echo 'selected'; ?>>nein</option >
</select>
<br />
 
 
 
    </span><br />
 <?php if ($sslon==true) { ?>   
   SSL-Übertragung<span class="infotext"> 
<select   name="VALUE[18]">
  <option value='nein' <?php if ("REX_VALUE[18]" == 'nein') echo 'selected'; ?>>nein</option>
  <option value='SSL' <?php if ("REX_VALUE[18]" == 'SSL') echo 'selected'; ?>>Ja</option >
</select>
<br />
 
 
 
    </span>
   <div class="infotext">(<em>ssldomain muss in der Modul-Ausgabe definiert sein</em></div>
   )
    <?php } ?>   
  </div>
  <div class="doleft"><strong>E-Mail geht an:</strong><br />
    <input type="email" name="VALUE[1]" value="REX_VALUE[1]" class="inp100" />
    <span class="formgenalias">(%Mail%)</span><br />
    <?php if ($bccon==true) { ?><strong>BCC an:</strong><br />
    <input type="text" name="VALUE[11]" value="REX_VALUE[11]" class="inp100" />
    <br /><?php } ?>
    <br />
    <strong>Soll eine Best&auml;tigungs-E-Mail erstellt werden? </strong>
    <select name="VALUE[10]" id="mySelect" onChange="doIt(this.value)">
      <option value='Nein' <?php if ("REX_VALUE[10]" == 'nein') echo 'selected'; ?>>Nein</option>
      <option value='ok' <?php if ("REX_VALUE[10]" == 'ok') echo 'selected'; ?>>Ja</option>
    </select>
    <br />
    <div class="infotext"><em>(Funktioniert nur wenn Validierung sender definiert ist)</em></div>
  </div><div style="clear:both"></div>
</div><?php if ($sessionson==true) { ?>
<div class="formgenheadline">Individuelle Sessionvariable (expert)</div>
  <div class="doform">
    <div class="doleft"><strong>Bezeichner für Sessionvariable:</strong><br/>
      <input type="text" name="VALUE[16]" value="REX_VALUE[16]" class="inp100" />
      <br />
    <span class="infotext">z.B.: Warenkorb,  nur für Session-Variablen erlaubte Zeichen, erntspricht: $_SESSION[&quot;Warenkorb&quot;]</span></div>
    <div class="doleft">
      <p><em><strong>Info</strong> Die Variable wird nach dem Versenden zurückgesetzt</em></p>
      <p>Beispiel: Einsatz per <strong>sessionvar|Warenkorb</strong></p>
    </div>
    <div style="clear:both">Es handelt sich hierbei um ein hidden field. Eine Ausgabe muss ggf. selbst erstellt werden.</div>
  </div>
   <?php } ?>
<?php if ($uploadon==true) { ?>
<div class="formgenheadline">Uploads</div>
  <div class="doform">
    <div class="doleft"></span> <strong>Uploadordner:</strong> (z.B.: files/upload/)<br />
      <input type="text" name="VALUE[14]" value="REX_VALUE[14]" class="inp100" />
      <br/>
 
      <?php
echo 'Maximale Dateiuploadgr&#246;&#223;e: ' . convertBytes( ini_get( 'upload_max_filesize' ) ) / 1048576 . 'MB';
?>
   </div>
    <div class="doleft">Die Uploads als Anhang versenden?
      <select name="VALUE[15]">
      <option value='Nein' <?php if ("REX_VALUE[15]" == 'nein') echo 'selected'; ?>>Nein</option>
      <option value='Ja' <?php if ("REX_VALUE[15]" == 'Ja') echo 'selected'; ?>>Ja</option>
      </select>
    </div>
    <div style="clear:both"></div>
  </div>
 
 <?php } ?>
  <br />
<div id="ok" <?php if ("REX_VALUE[10]" == 'ok'){ echo 'style="display:block;"'; } else echo 'style="display:none;"'; ?> class="myDivs">
  <div class="formgenheadline">Best&#228;tigungs-E-Mail an den Absender</div>
  <div class="doform">
    <div class="doleft">
    <strong>Betreff </strong>f&uuml;r die Best&auml;tigungs-E-Mail:<br />
      <input type="text" name="VALUE[17]" value="REX_VALUE[17]" class="inp100" />
 
    <strong>Absenderadresse </strong>f&uuml;r die Best&auml;tigungs-E-Mail:<br />
      <input type="email" name="VALUE[2]" value="REX_VALUE[2]" class="inp100" />
      <span class="formgenalias">(%Absender%)</span><br/>
<strong>Absender-Name:</strong><br />
      <input type="text" name="VALUE[8]" value="REX_VALUE[8]" class="inp100" />
    </div>
    <div class="doleft"><strong>Original-Mail anh&auml;ngen?<br />
<select name="VALUE[13]">
          <option value='nein' <?php if ("REX_VALUE[13]" == 'nein') echo 'selected'; ?>>nein</option >
          <option value='ja' <?php if ("REX_VALUE[13]" == 'ja') echo 'selected'; ?>>ja</option>
      </select>
        <br/>
        <br/>
Datei anh&#228;ngen: </strong>REX_MEDIA_BUTTON[1] </div>
    <div style="clear:both"></div>
  </div>
  <div class="formgenheadline">E-Mail-Best&#228;tigungstext</div>
  <div class="doform"><textarea name="VALUE[5]" class="formgenconfig" style="width:100%;height:80px;">REX_VALUE[5]</textarea>
    <span class="formgen_sample1"><strong>Platzhalter für Bestätigungstext:</strong> <br />
    %Betreff%, %Datum% , %Zeit%, %Absender%, %Mail%, %Vorname%, %Nachname% </span>, <br />
    %Besuchermail% (wird durch sender gesetzt)<br/>
  </div>
</div>
  <br/>
  
  <div class="formgenheadline"><strong>Danksagung</strong> (wird auf der Website  angezeigt)</div>
 <?php 
 $tinycheck= OOAddon::isActivated($weditor);
  if ($tinycheck == 1) { 
 ?>
 
   <textarea name="VALUE[6]" class="<?php echo $editstyle;?>" style="width:555px; height:250px;">REX_VALUE[6]</textarea>
   
<?php  }  else {
    echo' <div class="formgenerror"> Editor wurde nicht gefunden. <br/> Bitte installieren Sie das ADDON! </div>';
  } ?>
   
   
<br/>
  <div align="right">Bearbeitung: <a href="http://www.klxm.de" target="_blank">Thomas Skerbis - KLXM Crossmedia GmbH</a></div>
 
 
<div id="anleitung" style="<?php echo (!isset ($anleitung) || !$anleitung) ? 'display: none' : 'display: block'; ?>"> 
  <div class="formgenheadline">Beispiel-Formular:</div>
  <div class="doform">
    <textarea name="demo" cols="80" rows="11" class="formgenconfig" style="width:95%;height:200px;">
fieldstart|Kontaktdaten
text|Name|1|||checkfield    
text|Name|1|||name
text|Firma
text|Straße
text|PLZ|1|||plz
text|Ort|1
text|Telefon||||tel
text|Telefax||||tel
fieldend|
fieldstart|Weitere Angaben
divstart|cssklasse
radio|Geschlecht|0|Mann;Frau|m;w|
password|Ihr Passwort|1|||alpha
email|E-Mail|1|||sender
url|Website||||url
divend|
select|Auswahl|1||Birne;Apfel;Kirsche
checkbox|AGB gelesen?
fieldend|
info|Geben Sie bitte diesen Code oder nochmal Ihren Namen ein
text|Sicherheitscode|1|||check
textarea|Ihre Nachricht:|1|
upload|Upload JPG|0||jpg;jpeg;gif||0.5m
</textarea>
    <br/>
    <br/>
  </div>
  <div class="formgenheadline">Kurzbeschreibung:</div>
  klxm do form! 4.x basiert auf den in Redaxo 3.2 mitgelieferten Formular-Generator.<br />
   Beim ersten Aufruf erstellt das Modul eine Konfiguration für ein Standard-Kontaktformular. <br/>
     Im Beispiel-Formular sehen Sie Möglichkeiten zur Konfiguration. <br/>
<a href="http://wiki.redaxo.de/index.php?n=R4.DoForm" target="_blank">Eine ausf&uuml;hrliche Anleitung finden Sie im REDAXO Wiki.</a><br />
     <br />
<strong>Empfehlung:</strong><br />
     Wir empfehlen im PHP-Mailer die Einstellung SMTP-AUTH zu verwenden. 
  <br />
  <br />
<br/>
<br />
  <br />
  <br />
  <div class="doform">
    <div class="doleftdoc"><strong>Validierung</strong> von Textfeldern </div>
    <div class="doleftdoc2">
      <ul>
        <li>alpha (nur engl.Buchstaben) </li>
        <li>url (URL)</li>
        <li>digit (nur Zahlen)</li>
        <li>plz (5 Zahlen)</li>
        <li>plz4 (4 Zahlen)</li>
        <li>tel (mindestens 6 Zahlen)</li>
        <li>name prüft Namen und z.B. übliche Firmenbezeichnungen</li>
        <li>mail (pr&uuml;ft eingegebene E-Mail-Adressen) </li>
        <li>sender (diese Adresse wird als Absendermail eingesetzt und gepr&uuml;ft)</li>
        <li>check - Prüfen der Spamschutzeingabe (captchapic oder checkfield) <br/>
          entspricht sonst der Validierung: name</li>
        <li>checkfield (legt ein Vergleichsfeld fest das als Spamschutzcode gilt)</li>
      </ul>
      <p>&nbsp;</p>
    </div>
    <div style="clear:both"></div>
  </div>
  <br />
<br />
</div>
 
