redaxo do form! 5
=================
![](<do-code.jpg>) 
Formulargenerator für Redaxo CMS
--------------------------------

Es handelt sich hierbei um eine kostenlose und frei verwendbare Version, entsprechend der Lizenz Ihrer Redaxo-Installation. Eine Garantie oder Gewährleistung auf Funktionalität und Fehlerfreiheit wird nicht geleistet. Die KLXM Crossmedia haftet nicht für eventuell auftretenden Datenverlust. Bei Problemen, wenden Sie sich bitte an das Redaxo-Forum. 
Javascripte und CSS-Definitionen sind nicht Bestandteil der freien Version.

Homepage: http://klxm.de/produkte/redaxo-do-form/

Imressum: http://klxm.de/impressum/

Screenshot

![](<screenshot_.png>)


### Neu in Version 5.0 

Diese Version sollte nicht als Ersatz für do form! 4 eingesetzt werden.

-   Einige Felder und auch die Ausgaben unterscheiden sich.  Personalisierung
    erweitert, entsprechend Modul Nr. 653, zusätzlich mit Anrede-Erkennung für
    die Bestätigungsmail

-   Date-Feld wurde durch HTML5-Date-Feld ersetzt. Dadurch können die nativen
    Kalender-Widgets verwendet werden. Fallback per Jquery-Datepicker
    empfehlenswert. Durch den Parameter today, kann das aktuelle Datum
    vorausgewählt werden.

-   Das alte date-Feld heißt jetzt dateselect. xdate wurde entfernt.  
    IBAN und BIC können jetzt eingesetzt und validiert werden. In der
    Bestätigungs-E-Mail wird die IBAN anonymisiert.

Beispiele der neuen Felder:

`IBAN|Ihre IBAN|1|DE||iban `

`BIC|BIC|1|||bic `

`date|Datum der Meldung|1|today||date `

(Wird kein default-value eingegeben, werden entsprechende Placeholder in
modernen Browsern dargestellt)

Neue CSS-Klassen erleichtern die Gestaltung der Textfelder.

z.B.:

`.formgen .formtext.femail {} `

`.formgen .formtext.fIBAN {} `

`.formgen .formtext.fpassword {} `



Jedes Formularfeld befindet sich in einem DIV mit der Klasse .formfield. Bei
Fehlern kann man diese mit einer weiteren Klasse ergänzen.  Standard: .formerror
