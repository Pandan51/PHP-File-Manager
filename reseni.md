<h1>Zdůvodnění řešení</h1>

<h2>index.php</h2>
<p>
Hlavní stránka, kde vidíme složky a obrázky.
Tyto soubory a složky lze vytvářet, nebo nahrát 
z počítače a také je přejmenovat i smazat. 
Je zde zobrazena současná cesta. 
Lze se mezi složkami i přesouvat.
</p>

<p>
Přidávání, nahrávání, mazání a přejmenování 
posíláme do FileHandler.php přes HTTP POST requesty.
Pro navigaci mezi složkami je použit GET request,
směrován na index.php, kde upraví cestu.
</p>

<h2>FileHandler.php</h2>
<p>
Řeší POST requesty od index.php.
</p>
<ol>
<li>makeDirectory - Dostane název a vytvoří složku.</li>
<li>delete - Dostane název a rozliší,
jestli je cíl složka, nebo soubor a dle toho buď,
rekurzivně maže soubory složek, nebo rovnou smaže soubor.
</li>
<li>renameFile - Přejmenuje cíl a dá mu nový název.</li>
<li>fileUpload - Řeší nahrávání souborů</li>
</ol>

<h3>FileManager.php</h3>
<p>Pomocné metody pro práci se soubory.</p>
<h3>PathManager.php</h3>
<p>Pomocné metody pro správu cesty.</p>




