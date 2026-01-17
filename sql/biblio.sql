CREATE DATABASE IF NOT EXISTS biblio;
USE biblio;

CREATE TABLE Etudiant (
    CodeEtudiant INT PRIMARY KEY AUTO_INCREMENT,
    Nom VARCHAR(100) NOT NULL,
    Prenom VARCHAR(100) NOT NULL,
    Adresse TEXT,
    Classe VARCHAR(50)
);

CREATE TABLE Livre (
    CodeLivre INT PRIMARY KEY AUTO_INCREMENT,
    Titre VARCHAR(255) NOT NULL,
    Auteur VARCHAR(100) NOT NULL,
    DateEdition DATE
);

CREATE TABLE Emprunter (
    CodeEtudiant INT,
    CodeLivre INT,
    DateEmprunt DATE,
    PRIMARY KEY (CodeEtudiant, CodeLivre, DateEmprunt),
    FOREIGN KEY (CodeEtudiant) REFERENCES Etudiant(CodeEtudiant) ON DELETE CASCADE,
    FOREIGN KEY (CodeLivre) REFERENCES Livre(CodeLivre) ON DELETE CASCADE
);