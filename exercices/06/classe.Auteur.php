<?php
class Auteur {
  // Définition des constantes de classe.
  const PRENOM_ENTRE_PARENTHESES = 1;
  const PRENOM_APRES_VIRGULE = 2;
  // Définition des attributs.
  public  $nom;    // nom de l'auteur
  public  $prenom; // prénom de l'auteur
  // Méthode constructeur.
  public function __construct($patronyme) {
    // Initialiser le nom et le prénom
    // à partir du nom complet passé en paramètre.
    [$this->prenom,$this->nom] = explode(' ',$patronyme);
  }
  // Méthode de conversion de l'objet en chaîne
  public function __toString() {
    // Retourne juste le prénom et le nom.
    return "$this->prenom $this->nom";
  }
  // Méthode de mise en forme du nom de l'auteur.
  public function format($format = NULL) {
    switch ($format) {
      case Auteur::PRENOM_ENTRE_PARENTHESES:
        $valeur = "$this->nom ($this->prenom)";
        break;
      case Auteur::PRENOM_APRES_VIRGULE:
        $valeur = "$this->nom, $this->prenom";
        break;
      case NULL:
        $valeur = "$this->prenom $this->nom";
        break;
      default:
        throw new Exception('Format inconnu');
    };
    return $valeur;
  }
}
?>
