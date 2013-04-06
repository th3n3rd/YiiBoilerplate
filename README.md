# YiiBoilerplate
Struttura utilizzata da [Clevertech](http://www.clevertech.biz) e successivamente personalizzata in questo repository.

### Dettaglio Struttura

	/
    backend/
        components/
	    config/
            main-dev.php *
            main-prod.php *
            main.php
            params-dev.php *
            params-prod.php *
            params.php
            test.php
        controllers/
            SiteController.php
            ...
        extensions/
                behaviors/
                validators/
        lib/
        models/
            FormModel.php
            ...
        modules/
        runtime/ *
        views/
            layouts/
            site/
        widgets/
        www/
            assets/ *
            css/
            images/
            js/
            themes/
            index.php
            .htaccess
    common/
        components/
        config/
            params-dev.php *
            params-prod.php *
            params.php
        data/
        extensions/
        	behaviors/
        	validators/
        lib/
            Behat/
            Pear/
            Yii/
            Zend/
        messages/
        models/
        widgets/
    console/
		commands/
		components/
		config/
	    	environments/
		lib/
		migrations/
        models/
        runtime/ *
        yiic.php
    frontend/
		components/
		config/
	    	main-dev.php *
	    	main-prod.php
	    	main.php
	    	params-dev.php *
	    	params-prod.php *
	    	params.php
	    	test.php
		controllers/
		extensions/
			behaviors/
			validators/
		lib/
		models/	
		modules/	
		runtime/ *
		views/
    		layouts/
    		site/
		www/
	    	assets/ *
	    	css/
	    	files/
	    	images/
            	js/
            	less/
            index.php
            robots.txt
            .htaccess
    tests/
        bootstrap/
            FeatureContext.php
            YiiContext.php
        features/
            Startup.feature
        behat.yml
    
    INSTALL.md
    README.md
    runbehat
    runpostdeploy
    yiic
    yiic.bat

Se si lavora con un VCS (Version Control System) come Git o SVN, le directory/files marcati da un asterisco **non** devono essere inclusi nel sistema di versioning.

###Architettura Applicazione

Al livello più alto abbiamo:
  
* ***backend***: conterrà l'applicazione di backend per i moduli di amministrazione (in modo da evitare moduli admin nel frontend causando confusione)
* ***console***: conterrà l'applicazione a linea di comando.
* ***frontend***: conterrà l'applicazione responsabile del frontend.
* ***common***: conterrà i componenti comuni alle applicazione di cui sopra.
* ***test***: conterrà i test necessari per validare il corretto funzionamento dell'applicazione, seguendo il TDD (e BDD).

L'intera applicazione è suddivisa in 3 sotto applicazioni: backend, frontend e console, seguendo la struttura utilizzata dal [sito del framework yii](http://www.yiiframework.com/wiki/155/the-directory-structure-of-the-yii-project-site).

###Struttura Directory Applicazioni
La struttura interna delle sotto applicazioni **backend** e **frontend** è molto simile, i files utilizzati sono però specifici per le sotto applicazioni e quindi non condivisibili.
Nel caso in cui si ha la necessità di utilizzare gli stessic componenti è conveniente posizionare questi file nella sotto applicazione **common** che esiste proprio per fornire questo servizio.

Analizziamo ora la struttura interna mensionata in precedenza:

* ***components***: contiene i componenti (es. helpers, application components) utilizzate soltanto dalla specifica sotto applicazione
* ***config***: contiene le configurazioni utilizzate soltanto dalla specifica sotto applicazione
* ***controllers***: contiene le classi controller
* ***extensions***: estensioni di yii utilizzate soltanto dalla specifica sotto applicazione
* ***lib***: librerie di terze parti utilizzate soltanto dalla specifica sotto applicazione
* ***models***: contiene le classi model utilizzate soltanto dalla specifica applicazione
* ***modules***: contiene i moduli utilizzati soltanto dalla specifica sotto applicazione
* ***views***: contiene le view utilizzate dalle singole azioni delle classi controller
* ***widgets***: contiene le classi widget utilizzate soltanto dalla specifica sotto applicazione
* ***www***: la directory pubblica per la sotto applicazione

Le directory **extensions** e **widgets** potrebbero essere inglobate all'interno di **components** ma si è preferito lasciarle esplicite per facilitare la ricerca allo sviluppatore.

La struttura interna alla sotto applicazione **console** differisce dalle altre due nel senso che non necessita di **controllers**, **views**, **widgets**, **www**.
Infatti tutte le funzionalità necessarie sono disponibili all'interno della directory **commands** che contiene le classi command.
Inoltre è stata aggiunga alla sotto applicazione **console** la responsabilità di contenere la directory **migrations** con la quale sarà possibile eseguire le varie DB migrations.

###Applicazione Common
La sotto applicazione common che risiede all'interno della directory common conterrà tutte le directory/files condivisi dalle altre sotto applicazioni, in modo tale da ridurre la duplicazione del codice.

La struttura interna è molto simile a quella delle sotto applicazioni **backend** e **frontend** in modo da facilitare il lavoro allo sviluppatore.

###Configurazione dell'Applicazione
Generalmente le sotto applicazioni di un sistema condividono alcune configurazioni, per esempio i parametri della connessione al DB.
Per ridurre la duplicazione del codice la gestione della configurazione è stata centralizzata e inserita in **common**.

####Come Configurare l'Applicazione
Lo schema di configurazione adottato da YiiBoilerplate può sembrare complicato, inoltre questo è stato modificato come segue e quindi è necessario esplicitarne il suo funzionamento:

* **main.php**: configurazione di base per la sotto applicazione
* **main-dev.php**: configurazione valida per l'ambiente di sviluppo (developer) per la sotto applicazione
* **main-prod.php**: configurazione valida per l'ambiente di produzione per la sotto applicazione
* **params.php**: parametri di applicazione di base per la stto applicazione
* **params-local.php**: parametri di applicazione validi per l'ambiente di sviluppo (developer) per la stto applicazione
* **params-local.php**: parametri di applicazione validi per l'ambiente di produzioe per la stto applicazione
* **test.php**: configurazione valida durante l'esecuzione dei test

A seconda del valore della costante **YII_DEBUG** l'applicazione esegue lo switch tra gli ambienti di sviluppo e produzione, verranno richiamati rispettivamente **main-dev.php** o **main-prod.php** andando a sovrascrivere le configurazioni presenti anche in **main.php**.

Stessa cosa vale per i parametri di configurazione.

####Lo script _runpostdeploy_
Lo script di postdeply va a creare le directory **non** condivise come **runtime** e **assets** all'interno delle sotto applicazioni.
Se specificato avvia l'esecuzione delle migrazioni, è sconsigliato automatizzare le migrazioni in ambiente di sviluppo.

Per avviare lo script di post deploy basta posizionarsi all'interno della root dell'applicazione ed eseguire:

```
./runpostdeploy migrations
```

Gli argomenti disponibili sono:

* **migrations** (optional): può essere "**migrate**"" o "**no-migrate**".
	* migrate: esegue le migrazioni
	* no-migrate: non esegue le migrazioni

====
