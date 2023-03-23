<!-- Obrazac za unošenje novih riječi -->
<form action="#" method="get">
    <p>Upišite riječ</p>
    <input type="text" name="word" required> <!-- required jedno od načina da polje da ne smije biti prazno -->
    <button type="submit">Pošalji</button>
</form>
<?php      
if($_GET)
{
    $word = $_GET['word'];
    $numOfletters = strlen(trim($word," ")); 
    $numOfletters. "\n";
    //funkcija strlen() vraća dužinu stringa također sa praznim mjestima(razmakom), 
    //funkcija trim() uklanja ono što nama ne treba, u ovom slučaju razmak kako je navedeno na drugom parametru
}
else
{
    echo "Polje ne smije biti prazno!";
}
//kreiranje funkcije pomoću koje ćemo unesenu riječ obraditi na način da ćemo izračunati koliko ima samoglasnika i suglasnika
function wordsFilter($arg){
    $str = $_GET['word'];
    if((isset($str))){ 
        $vowels = ['a','e','i','o','u'];
        $numOfVowels = 0;
        $numOfConsonants = 0;
        
        for($i = 0; $i<strlen($str); $i++)
        {
            if(in_array($str[$i], $vowels)){
                $numOfVowels++;
            }
            else{
                $numOfConsonants++;
            }
        }
    }
    //Vraćanje iz navedene funkcije samoglasnike i suglasnike u array vrijednost
    return [$numOfVowels, $numOfConsonants];
}
//spremanje funkcije u varijablu sa njenim vrijednostima koje smo vratitli u obliku array-a
$wordStatus = wordsFilter($numOfVowels);
$wordStatus = wordsFilter($numOfConsonants);
//pozivanje json datoteke i njenog sadržaja
$wordJson = file_get_contents('words.json');
$words = json_decode($wordJson, true); 
//dodavanje riječi unutar tablice
if(empty($numOfletters))
{
    echo "Polje ne smije biti prazno!";
}
else{ 
    $wordSave = [
        'word' => $word,
        'letters' => $numOfletters,
        'vowels' => $wordStatus[0],
        'consonants' => $wordStatus[1]
    ];
    $words[] = $wordSave;
    file_put_contents('words.json', json_encode($words, JSON_PRETTY_PRINT)); 
}
?>
<table border="1">
<tr>
    <th>Riječi</th>
    <th>Broj slova</th>
    <th>Broj suglasnika</th>
    <th>Broj samoglasnika</th>
</tr>
<?php 
//petlja foreach za ispis svake riječi unutar tablice
foreach($words as $word) { ?>
    <tr>
        <td><?= $word['word']; ?></td>
        <td><?= $word['letters']; ?></td>
        <td><?= $word['consonants']; ?></td>
        <td><?= $word['vowels']; ?></td>
    </tr>
<?php }  ?>
</table>
</body>
</html>