CREATE TABLE Utilisateur (
	idUtilisateur int,
	nomU VARCHAR(50),
	prenomU VARCHAR(50),
	mailU VARCHAR(50),
	telU VARCHAR(20),
	mdp VARCHAR(50),
	role VARCHAR(50),
	datecreation DATE,
	constraint pk_idUtilisateur PRIMARY KEY(idUtilisateur),
	constraint check_role CHECK (`role` IN ('admin', 'client', 'apiculteur'))
	);

CREATE TABLE Emplacement (
	idEmplacement INT,
	nomLieu VARCHAR(50),
	adresse VARCHAR(50),
	idUtilisateur int,
	constraint pk_idEmplacement_emplacement PRIMARY KEY(idEmplacement),
	constraint fk_idUtilisateur_utilisateur FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur(idUtilisateur)	
);

CREATE TABLE Ruche (
	idRuche int,
	nom VARCHAR(50),
	dateInstallation DATE,
	especeAbeille VARCHAR(50),
	statut VARCHAR(50),
	idEmplacement int,
	constraint pk_idRuche_ruche PRIMARY KEY (idRuche ),
	constraint fk_emplacement_ruche FOREIGN KEY (idEmplacement) REFERENCES Emplacement(idEmplacement),
		constraint check_statut_ruche CHECK (statut IN('active','inactive', 'maintenance'))
);


CREATE TABLE PanneauSolaire (
    idPanSol INT,
    puissanceW FLOAT NOT NULL,
    rendement FLOAT NOT NULL,
    etatP VARCHAR(10) NOT NULL,
    dateInstallationP DATE NOT NULL,
    CONSTRAINT pk_PanneauSolaire PRIMARY KEY (idPanSol),
    CONSTRAINT chk_puissanceW_pansol CHECK (puissanceW > 0),
    CONSTRAINT chk_rendement_pansol CHECK (rendement BETWEEN 0 AND 100),
    CONSTRAINT chk_etatP_pansol CHECK (etatP IN ('actif', 'inactif'))
);







CREATE TABLE Batterie (
    idBatterie INT,
    capaciteW FLOAT NOT NULL,
    niveauCharge FLOAT NOT NULL,
    etatB VARCHAR(15) NOT NULL,
    dateInstallationB DATE NOT NULL,
    idPanSol INT,
    idRuche INT,
    CONSTRAINT pk_Batterie PRIMARY KEY (idBatterie),
    CONSTRAINT chk_capaciteW_batterie CHECK (capaciteW > 0),
    CONSTRAINT chk_niveauCharge_batterie CHECK (niveauCharge BETWEEN 0 AND 100),
    CONSTRAINT chk_etatB_batterie CHECK (etatB IN ('charge', 'décharge', 'repos')),
    CONSTRAINT fk_Batterie_PanneauSolaire FOREIGN KEY (idPanSol) REFERENCES PanneauSolaire(idPanSol),
    CONSTRAINT fk_Batterie_Ruche  FOREIGN KEY (idRuche) REFERENCES Ruche(idRuche)
);


CREATE TABLE Balance(
idBalance INT,
poids INT,
datemesure DATE NOT NULL,
etatBalance VARCHAR(50),
idRuche INT,
constraint pk_balance PRIMARY KEY (idBalance),
CONSTRAINT check_anomalie_poids CHECK ((poids < 40 OR poids > 60) AND etatBalance = 'anomalie' OR (poids >= 40 AND poids <= 60)),
constraint chek_poids_balance CHECK (poids BETWEEN 20 AND 80),
constraint fk_idRuche_balance  FOREIGN KEY (idRuche) REFERENCES Ruche(idRuche)
);


create table Multisensor(
	idSensor int,
	temperature float,
	humidite float,
	vibration int,
	uv int,
	etat varchar(30),
	nbPassage int,
	idRuche int,
	constraint pk_sensor_multisensor primary key(idSensor),
	constraint fk_idRuche_sensor foreign key(idRuche) references Ruche(idRuche),
	constraint check_etat_sensor CHECK (etat IN('calme','actif','alerte', 'essaimage','hibernation'))
	);

create table Ouverture_Ruche(
	idDoor int,
	ouvert boolean,
	alarme varchar(30),
	idRuche int,
	constraint pk_door_ouverture_ruche primary key(idDoor),
	constraint fk_idRuche_door foreign key(idRuche) references Ruche(idRuche)
	);

create table Lcd (
	idLcd int,
	modeAffichage varchar(50),
	derniereMAJ date,
	idRuche int,
	idSensor int,
	constraint pk_lcd primary key(idLcd),
	constraint fk_idRuche foreign key(idRuche) references Ruche(idRuche),
	constraint fk_idSensor foreign key(idSensor) references Multisensor(idSensor),
	constraint check_modeAffichage CHECK (modeAffichage IN( 'température', 'humidité', 'vibration', 'uv' , 'nbPassage', 'etat'))
	);


CREATE TABLE Bouton(
idBouton int,
nbAppuis int,
`action` VARCHAR(50),
horodatage DATE,
idSensor int,
idLcd int,
idDoor int,
CONSTRAINT pk_idBouton PRIMARY KEY (idBouton),
CONSTRAINT fk_sensor_bouton FOREIGN KEY (idSensor) REFERENCES Multisensor(idSensor),
CONSTRAINT fk_lcd_bouton FOREIGN KEY (idLcd) REFERENCES Lcd(idLcd),
CONSTRAINT fk_door_bouton FOREIGN KEY (idDoor) REFERENCES Ouverture_Ruche(idDoor)
);


create table Tapis_Chauffant(  
idTapis int,
etat_t boolean,
modeControle_t VARCHAR(50),
seuilDeclenchement_t int,
idRuche int,
idSensor int,
CONSTRAINT pk_idTapis PRIMARY KEY (idTapis),
CONSTRAINT fk_ruche_tapis FOREIGN KEY (idRuche) REFERENCES Ruche(idRuche),
CONSTRAINT fk_sensor_tapis FOREIGN KEY (idSensor) REFERENCES Multisensor(idSensor),
CONSTRAINT check_mode_tapis CHECK (modeControle_t IN ('on' , 'off',  'auto' ))
);


create Table Ventilation(
idVentilation int,
etat_v boolean,
modeControle_v VARCHAR(50),
seuilDeclenchement_v int,
idRuche int,
idSensor int,
CONSTRAINT pk_idVentilation PRIMARY KEY (idVentilation),
CONSTRAINT fk_ruche_ventilation FOREIGN KEY (idRuche) REFERENCES Ruche(idRuche),
CONSTRAINT fk_sensor_ventilation FOREIGN KEY (idSensor) REFERENCES Multisensor(idSensor),
CONSTRAINT check_mode_ventilation CHECK (modeControle_v  IN (  'on' ,  'off',  'auto'))

);






CREATE TABLE Prise (
	idPrise INT NOT NULL, 
	consommationW FLOAT,
	etatPrise BOOLEAN,
	idVentilation INT,
	idTapis INT,
	idBatterie INT,
PRIMARY KEY(idPrise),
CONSTRAINT fk_idVentilation FOREIGN KEY(idVentilation)REFERENCES Ventilation(idVentilation),
	CONSTRAINT fk_idTapis FOREIGN KEY(idTapis) REFERENCES Tapis_Chauffant(idTapis),
	CONSTRAINT fk_idBatterie FOREIGN KEY(idBatterie) REFERENCES Batterie(idBatterie),
CONSTRAINT check_conso_positif CHECK (consommationW >= 0.)
);
CREATE TABLE Commande (
	idCommande INT NOT NULL,
	`date` Date,
	total FLOAT,
idUtilisateur INT,
	PRIMARY KEY(idCommande),
	CONSTRAINT fk_idUtilisateur_commande FOREIGN KEY(idUtilisateur) references Utilisateur(idUtilisateur),
CONSTRAINT check_total_positif CHECK (total > 0.)
);
CREATE TABLE Produit (
	idProduit INT NOT NULL,
	nomProduit VARCHAR(50),
	prix FLOAT,
	dateRecolte date,
	format int,
	idUtilisateur int, 
	idRuche int,
	CONSTRAINT pk_produit PRIMARY KEY(idProduit),
CONSTRAINT fk_idUtilisateur_produit FOREIGN KEY(idUtilisateur) REFERENCES Utilisateur(idUtilisateur),
	CONSTRAINT fk_idRuche_produit FOREIGN KEY(idRuche) REFERENCES Ruche(idRuche),
	CONSTRAINT check_prix_positif CHECK (prix > 0.),
	CONSTRAINT check_format_produit CHECK (format >=100)
);

CREATE TABLE Historique (
    idHistorique INT,
    typeEvenement VARCHAR(50),
    valeur VARCHAR(255),
    description  VARCHAR(255), 
    datedbt DATETIME,
    datefin DATETIME,
    idSensor INT,
    idPrise INT,
    idBouton INT,
    idTapis INT,
    idVentilation INT,
    idBalance INT,
    constraint pk_historique PRIMARY KEY ( idHistorique),
    constraint fk_sensor_histo FOREIGN KEY (idSensor) REFERENCES Multisensor(idSensor),
    constraint fk_prise_histo FOREIGN KEY (idPrise) REFERENCES Prise(idPrise),
   constraint fk_bouton_histo  FOREIGN KEY (idBouton) REFERENCES Bouton(idBouton),
    constraint fk_tapis_histo FOREIGN KEY (idTapis) REFERENCES Tapis_Chauffant(idTapis),
    constraint fk_ventilation_histo FOREIGN KEY (idVentilation) REFERENCES Ventilation(idVentilation),
    constraint fk_balance_histo FOREIGN KEY (idBalance) REFERENCES Balance(idBalance)
);

CREATE TABLE Contenir (
    idCommande INT,
    idProduit INT,
    quantitep INT,
    constraint pk_commande_produit_contenir PRIMARY KEY (idCommande, idProduit),
    constraint fk_commande_contenir FOREIGN KEY (idCommande) REFERENCES Commande (idCommande),
    constraint fk_produit_contenir FOREIGN KEY (idProduit) REFERENCES Produit(idProduit)
);

CREATE TABLE Gerer (
    idUtilisateur INT,
    idRuche INT,
    constraint pk_utilisateur_ruche_gerer PRIMARY KEY (idUtilisateur, idRuche),
    constraint fk_utilisateur_gerer FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur(idUtilisateur),
    constraint fk_ruche_gerer  FOREIGN KEY (idRuche) REFERENCES Ruche(idRuche)	
);




