
delete from Historique;
delete from Contenir;
delete from Gerer;
delete from Bouton;
delete from Lcd;
delete from Prise;
delete from Ventilation;
delete from Tapis_Chauffant;
delete from Ouverture_Ruche;
delete from Multisensor;
delete from Balance;
delete from Batterie;
delete from PanneauSolaire;
delete from Produit;
delete from Commande;
delete from Ruche;
delete from Emplacement;
delete from Utilisateur;


insert into Utilisateur( idUtilisateur, nomU, prenomU, mailU, telU, mdp, role, datecreation) 
VALUES (1, 'Durand', 'Paul', 'paul.durand@gmail.com', 0611223344, 'mdp123', 'admin', '2024-01-01');
insert into Utilisateur( idUtilisateur, nomU, prenomU, mailU, telU, mdp, role, datecreation) 
VALUES (2, 'Leroy', 'Sophie', 'sophie.leroy@yahoo.fr', 0622334455, 'mdp456', 'client', '2024-02-10');
insert into Utilisateur( idUtilisateur, nomU, prenomU, mailU, telU, mdp, role, datecreation)
 VALUES (3,' Dupont', 'Jean', 'j.dupont@api.fr', 0612345678, 'mdp789', 'apiculteur', '2024-03-15');
insert into Utilisateur( idUtilisateur, nomU, prenomU, mailU, telU, mdp, role, datecreation) 
VALUES (4, 'Simon', 'Julie', 'julie.simon@gmail.com', 0644556688, 'mdp321', 'client', '2024-04-01');
insert into Utilisateur( idUtilisateur, nomU, prenomU, mailU, telU, mdp, role, datecreation) 
VALUES (5, 'Laurent', 'Hugo', 'hugo.laurent@yahoo.fr', 0655667788, 'mdp654', 'client', '2024-05-12');
insert into Utilisateur( idUtilisateur, nomU, prenomU, mailU, telU, mdp, role, datecreation)
 VALUES (6, 'Moreau', 'Julie', 'julie.moreau@gmail.com', 0633445566, 'mdp987', 'apiculteur', '2024-06-20');
insert into Utilisateur( idUtilisateur, nomU, prenomU, mailU, telU, mdp, role, datecreation)
 VALUES (7, 'Bernard', 'Leo', 'leo.bernard@gmail.com', 0677889900, 'mdp111', 'client', '2024-07-10');
insert into Utilisateur( idUtilisateur, nomU, prenomU, mailU, telU, mdp, role, datecreation) 
VALUES (8, 'Robert', 'Nina', 'nina.robert@yahoo.fr', 0688990011, 'mdp222', 'client', '2024-08-18');
insert into Utilisateur( idUtilisateur, nomU, prenomU, mailU, telU, mdp, role, datecreation) 
VALUES (9, 'Simon', 'Marc', 'marc.simon@api.fr', 0644556677, 'mdp333', 'apiculteur', '2024-09-25');
insert into Utilisateur( idUtilisateur, nomU, prenomU, mailU, telU, mdp, role, datecreation) 
VALUES (10, 'Petit', 'Lea', 'lea.petit@gmail.com', 0610101010, 'mdp444', 'client', '2024-10-30');


insert into Emplacement(idEmplacement, nomLieu, adresse, idUtilisateur) values 
	(1, 'Champ Sud', 'Toulouse', 3);
insert into Emplacement(idEmplacement, nomLieu, adresse, idUtilisateur) values 
	(2, 'Forêt Nord', 'Montauban', 3);
insert into Emplacement(idEmplacement, nomLieu, adresse, idUtilisateur) values 
	(3, 'Prairie Est', 'Albi', 3);
insert into Emplacement(idEmplacement, nomLieu, adresse, idUtilisateur) values 
	(4, 'Vallée Ouest', 'Auch', 6);
insert into Emplacement(idEmplacement, nomLieu, adresse, idUtilisateur) values 
	(5, 'Colline Verte', 'Cahors', 6);
insert into Emplacement(idEmplacement, nomLieu, adresse, idUtilisateur) values 
	(6, 'Bois Clair', 'Foix', 6);
insert into Emplacement(idEmplacement, nomLieu, adresse, idUtilisateur) values 
	(7, 'Plaine Dorée', 'Castres', 9);
insert into Emplacement(idEmplacement, nomLieu, adresse, idUtilisateur) values 
	(8, 'Rive Bleue', 'Tarbes', 9);
insert into Emplacement(idEmplacement, nomLieu, adresse, idUtilisateur) values 
	(9, 'Montagne Haute', 'Rodez', 9);
insert into Emplacement(idEmplacement, nomLieu, adresse, idUtilisateur) values 
	(10, 'Champ Fleuri', 'Carcassonne', 9);

insert into Ruche(idRuche , nom, dateInstallation, especeAbeille, statut, idEmplacement) 
VALUES (1, 'Ruche_A1', '2024-01-10', 'Apis mellifera', 'active', 1);
insert into Ruche(idRuche , nom, dateInstallation, especeAbeille, statut, idEmplacement) 
VALUES (2, 'Ruche_B2', '2024-02-15', 'Apis cerana', 'inactive', 2);
insert into Ruche(idRuche , nom, dateInstallation, especeAbeille, statut, idEmplacement) 
VALUES (3, 'Ruche_C3',' 2024-03-20', 'Apis mellifera', 'maintenance', 3);
insert into Ruche(idRuche , nom, dateInstallation, especeAbeille, statut, idEmplacement) 
VALUES (4, 'Ruche_D4', '2024-04-05', 'Apis dorsata', 'active', 4);
insert into Ruche(idRuche , nom, dateInstallation, especeAbeille, statut, idEmplacement) 
VALUES (5, 'Ruche_E5', '2024-05-12', 'Apis florea', 'inactive', 5);
insert into Ruche(idRuche , nom, dateInstallation, especeAbeille, statut, idEmplacement) 
VALUES (6, 'Ruche_F6', '2024-06-18', 'Apis mellifera', 'active', 6);
insert into Ruche(idRuche , nom, dateInstallation, especeAbeille, statut, idEmplacement) 
VALUES (7, 'Ruche_G7',' 2024-07-22',' Apis cerana', 'maintenance', 7);
insert into Ruche(idRuche , nom, dateInstallation, especeAbeille, statut, idEmplacement) 
VALUES (8, 'Ruche_H8', '2024-08-30',' Apis dorsata', 'active', 8);
insert into Ruche(idRuche , nom, dateInstallation, especeAbeille, statut, idEmplacement) 
VALUES (9, 'Ruche_I9', '2024-09-14', 'Apis florea', 'inactive', 9);
insert into Ruche(idRuche , nom, dateInstallation, especeAbeille, statut, idEmplacement) 
VALUES (10, 'Ruche_J10',' 2024-10-01', 'Apis mellifera', 'active', 10);

insert into Commande(idCommande, date, total, idUtilisateur) VALUES (1, '2025-03-01', 150.0, 1);
insert into Commande(idCommande, date, total, idUtilisateur) VALUES (2, '2025-03-02', 90.0, 2);
insert into Commande(idCommande, date, total, idUtilisateur) VALUES (3, '2025-03-03', 200.0, 3);
insert into Commande(idCommande, date, total, idUtilisateur) VALUES (4, '2025-03-04', 120.0, 4);
insert into Commande(idCommande, date, total, idUtilisateur) VALUES (5, '2025-03-05', 80.0, 5);
insert into Commande(idCommande, date, total, idUtilisateur) VALUES (6, '2025-03-06', 60.0, 6);
insert into Commande(idCommande, date, total, idUtilisateur) VALUES (7, '2025-03-07', 140.0, 7);
insert into Commande(idCommande, date, total, idUtilisateur) VALUES (8, '2025-03-08', 75.0, 8);
insert into Commande(idCommande, date, total, idUtilisateur) VALUES (9, '2025-03-09', 95.0, 9);
insert into Commande(idCommande, date, total, idUtilisateur) VALUES (10, '2025-03-10', 180.0, 10);


insert into Produit(idProduit, nomProduit, prix, dateRecolte, format, idUtilisateur, idRuche) VALUES (1, 'Miel Lavande',10.0, '2024-09-01', 100, 1, 1);
insert into Produit(idProduit, nomProduit, prix, dateRecolte, format, idUtilisateur, idRuche) VALUES (2, 'Miel Acacia', 12.0, '2024-09-04', 300, 2, 2);
insert into Produit(idProduit, nomProduit, prix, dateRecolte, format, idUtilisateur, idRuche) VALUES (3, 'Cire Abeille', 8.0, '2024-05-19', 500, 3, 3);
insert into Produit(idProduit, nomProduit, prix, dateRecolte, format, idUtilisateur, idRuche) VALUES (4, 'Miel Forêt', 11.0, '2024-02-01', 100, 4, 4);
insert into Produit(idProduit, nomProduit, prix, dateRecolte, format, idUtilisateur, idRuche) VALUES (5, 'Pollen', 9.0, '2024-08-04', 300, 5, 5);
insert into Produit(idProduit, nomProduit, prix, dateRecolte, format, idUtilisateur, idRuche) VALUES (6, 'Gelée Royale', 15.0, '2024-06-23', 500, 6, 6);
insert into Produit(idProduit, nomProduit, prix, dateRecolte, format, idUtilisateur, idRuche) VALUES (7, 'Propolis', 13.0, '2024-11-01', 200, 7, 7);
insert into Produit(idProduit, nomProduit, prix, dateRecolte, format, idUtilisateur, idRuche) VALUES (8, 'Miel Thym', 14.0, '2024-10-01', 750, 8, 8);
insert into Produit(idProduit, nomProduit, prix, dateRecolte, format, idUtilisateur, idRuche) VALUES (9, 'Miel Fleurs', 10.0, '2024-07-15', 1000, 9, 9);
insert into Produit(idProduit, nomProduit, prix, dateRecolte, format, idUtilisateur, idRuche) VALUES (10, 'Cire Bougie', 7.0, '2024-08-25', 750, 10, 10);

insert into PanneauSolaire (idPanSol, puissanceW, rendement, etatP, dateInstallationP) values
	(1, 300, 85, 'actif', '2024-01-01');
insert into PanneauSolaire (idPanSol, puissanceW, rendement, etatP, dateInstallationP) values 
	(2, 250, 80, 'actif', '2024-02-01');
insert into PanneauSolaire (idPanSol, puissanceW, rendement, etatP, dateInstallationP) values
	(3, 320, 88, 'actif', '2024-03-01');
insert into PanneauSolaire (idPanSol, puissanceW, rendement, etatP, dateInstallationP) values 
	(4, 200, 75, 'inactif', '2024-04-01');
insert into PanneauSolaire (idPanSol, puissanceW, rendement, etatP, dateInstallationP) values
	(5, 280, 82, 'actif', '2024-05-01');
insert into PanneauSolaire (idPanSol, puissanceW, rendement, etatP, dateInstallationP) values 
	(6, 310, 87, 'actif', '2024-06-01');
insert into PanneauSolaire (idPanSol, puissanceW, rendement, etatP, dateInstallationP) values
	(7, 260, 78, 'actif', '2024-07-01');
insert into PanneauSolaire (idPanSol, puissanceW, rendement, etatP, dateInstallationP) values 
	(8, 290, 84, 'actif', '2024-08-01');
insert into PanneauSolaire (idPanSol, puissanceW, rendement, etatP, dateInstallationP) values
	(9, 270, 81, 'actif', '2024-09-01');
insert into PanneauSolaire (idPanSol, puissanceW, rendement, etatP, dateInstallationP) values 
	(10, 300, 86, 'actif', '2024-10-01');


insert into Batterie( idBatterie ,capaciteW,niveauCharge,etatB,dateInstallationB,idPanSol,idRuche)
values(1, 500, 80, 'charge', '2024-01-10', 1, 1);
insert into Batterie( idBatterie ,capaciteW,niveauCharge,etatB,dateInstallationB,idPanSol,idRuche)
values(2, 450, 60, 'décharge', '2024-02-10', 2, 2);
insert into Batterie( idBatterie ,capaciteW,niveauCharge,etatB,dateInstallationB,idPanSol,idRuche)
values(3, 600, 90, 'charge', '2024-03-10', 3, 3);
insert into Batterie( idBatterie ,capaciteW,niveauCharge,etatB,dateInstallationB,idPanSol,idRuche)
values(4, 400, 40, 'décharge', '2024-04-10', 4, 4);
insert into Batterie( idBatterie ,capaciteW,niveauCharge,etatB,dateInstallationB,idPanSol,idRuche)
values(5, 550, 70, 'repos', '2024-05-10', 5, 5);
insert into Batterie( idBatterie ,capaciteW,niveauCharge,etatB,dateInstallationB,idPanSol,idRuche)
values(6, 650, 95, 'charge', '2024-06-10', 6, 6);
insert into Batterie( idBatterie ,capaciteW,niveauCharge,etatB,dateInstallationB,idPanSol,idRuche)
values(7, 480, 50, 'repos', '2024-07-10', 7, 7);
insert into Batterie( idBatterie ,capaciteW,niveauCharge,etatB,dateInstallationB,idPanSol,idRuche)
values(8, 520, 65, 'charge', '2024-08-10', 8, 8);
insert into Batterie( idBatterie ,capaciteW,niveauCharge,etatB,dateInstallationB,idPanSol,idRuche)
values(9, 470, 55, 'décharge', '2024-09-10', 9, 9);
insert into Batterie( idBatterie ,capaciteW,niveauCharge,etatB,dateInstallationB,idPanSol,idRuche)
values(10, 600, 85, 'charge', '2024-10-10', 10,10);


insert into Balance( idBalance, poids, datemesure, etatBalance, idRuche ) VALUES (1, 45, '2025-04-01','normal', 1);
insert into Balance( idBalance, poids, datemesure, etatBalance, idRuche ) VALUES (2, 35, '2025-04-02','anomalie', 2);
insert into Balance( idBalance, poids, datemesure, etatBalance, idRuche ) VALUES (3, 47, '2025-04-03', 'normal', 3);
insert into Balance( idBalance, poids, datemesure, etatBalance, idRuche ) VALUES (4, 32, '2025-04-04', 'anomalie', 4);
insert into Balance( idBalance, poids, datemesure, etatBalance, idRuche ) VALUES (5, 65, '2025-04-05', 'anomalie', 5);
insert into Balance( idBalance, poids, datemesure, etatBalance, idRuche ) VALUES (6, 50, '2025-04-06', 'normal', 6);
insert into Balance( idBalance, poids, datemesure, etatBalance, idRuche ) VALUES (7, 49, '2025-04-07', 'normal', 7);
insert into Balance( idBalance, poids, datemesure, etatBalance, idRuche ) VALUES (8, 70, '2025-04-08', 'anomalie', 8);
insert into Balance( idBalance, poids, datemesure, etatBalance, idRuche ) VALUES (9,59, '2025-04-09', 'normal', 9);
insert into Balance( idBalance, poids, datemesure, etatBalance, idRuche ) VALUES (10, 52, '2025-04-10', 'normal', 10);



insert into Multisensor(idSensor, temperature, humidite, vibration, uv, etat, nbPassage, idRuche) values 
	(1, 35, 60, 2, 5, 'calme', 120, 1);
insert into Multisensor(idSensor, temperature, humidite, vibration, uv, etat, nbPassage, idRuche) values 
	(2, 33, 55, 1, 4, 'actif', 98, 2);
insert into Multisensor(idSensor, temperature, humidite, vibration, uv, etat, nbPassage, idRuche) values 
	(3, 36, 65, 3, 6, 'essaimage', 150, 3);
insert into Multisensor(idSensor, temperature, humidite, vibration, uv, etat, nbPassage, idRuche) values 
	(4, 30, 50, 1, 3, 'hibernation', 80, 4);
insert into Multisensor(idSensor, temperature, humidite, vibration, uv, etat, nbPassage, idRuche) values 
	(5, 34, 58, 2, 5, 'actif', 110, 5);
insert into Multisensor(idSensor, temperature, humidite, vibration, uv, etat, nbPassage, idRuche) values 
	(6, 37, 70, 4, 7, 'essaimage', 200, 6);
insert into Multisensor(idSensor, temperature, humidite, vibration, uv, etat, nbPassage, idRuche) values 
	(7, 29, 45, 1, 2, 'calme', 60, 7);
insert into Multisensor(idSensor, temperature, humidite, vibration, uv, etat, nbPassage, idRuche) values 
	(8, 32, 52, 2, 4, 'actif', 95, 8);
insert into Multisensor(idSensor, temperature, humidite, vibration, uv, etat, nbPassage, idRuche) values 
	(9, 31, 48, 1, 3, 'calme', 85, 9);
insert into Multisensor(idSensor, temperature, humidite, vibration, uv, etat, nbPassage, idRuche) values 
	(10, 38, 75, 5, 8, 'essaimage', 220, 10);

insert into Ouverture_Ruche(idDoor, ouvert, alarme, idRuche) values 
	(1, true, 'aucune', 1);
insert into Ouverture_Ruche(idDoor, ouvert, alarme, idRuche) values 
	(2, false, 'intrusion', 2);
insert into Ouverture_Ruche(idDoor, ouvert, alarme, idRuche) values 
	(3, true, 'aucune', 3);
insert into Ouverture_Ruche(idDoor, ouvert, alarme, idRuche) values 
	(4, false, 'erreur', 4);
insert into Ouverture_Ruche(idDoor, ouvert, alarme, idRuche) values 
	(5, true, 'aucune', 5);
insert into Ouverture_Ruche(idDoor, ouvert, alarme, idRuche) values 
	(6, false, 'intrusion', 6);
insert into Ouverture_Ruche(idDoor, ouvert, alarme, idRuche) values 
	(7, true, 'aucune', 7);
insert into Ouverture_Ruche(idDoor, ouvert, alarme, idRuche) values 
	(8, false, 'panne', 8);
insert into Ouverture_Ruche(idDoor, ouvert, alarme, idRuche) values 
	(9, true, 'aucune', 9);
insert into Ouverture_Ruche(idDoor, ouvert, alarme, idRuche) values 
	(10, false, 'intrusion', 10);

insert into Tapis_Chauffant(idTapis, etat_t, modeControle_t, seuilDeclenchement_t, idRuche, idSensor) values 
	(1, true, 'auto', 30, 1, 1);
insert into Tapis_Chauffant(idTapis, etat_t, modeControle_t, seuilDeclenchement_t, idRuche, idSensor) values 
	(2, true, 'on', 28, 2, 2);
insert into Tapis_Chauffant(idTapis, etat_t, modeControle_t, seuilDeclenchement_t, idRuche, idSensor) values 
	(3, true, 'on', 32, 3, 3);
insert into Tapis_Chauffant(idTapis, etat_t, modeControle_t, seuilDeclenchement_t, idRuche, idSensor) values 
	(4, false, 'auto', 33, 4, 4);
insert into Tapis_Chauffant(idTapis, etat_t, modeControle_t, seuilDeclenchement_t, idRuche, idSensor) values 
	(5, true , 'auto', 31, 5, 5);
insert into Tapis_Chauffant(idTapis, etat_t, modeControle_t, seuilDeclenchement_t, idRuche, idSensor) values 
	(6, false, 'off', 34, 6, 6);
insert into Tapis_Chauffant(idTapis, etat_t, modeControle_t, seuilDeclenchement_t, idRuche, idSensor) values 
	(7, true, 'on', 31, 7, 7);
insert into Tapis_Chauffant(idTapis, etat_t, modeControle_t, seuilDeclenchement_t, idRuche, idSensor) values 
	(8, false, 'auto', 33, 8, 8);
insert into Tapis_Chauffant(idTapis, etat_t, modeControle_t, seuilDeclenchement_t, idRuche, idSensor) values 
	(9, false, 'auto', 34, 9, 9);
insert into Tapis_Chauffant(idTapis, etat_t, modeControle_t, seuilDeclenchement_t, idRuche, idSensor) values 
	(10, true, 'on', 28, 10, 10);

insert into Ventilation (idVentilation, etat_v, modeControle_v,seuilDeclenchement_v, idRuche, idSensor) values 
(1, false, 'auto', 35, 1, 1);
insert into Ventilation (idVentilation, etat_v, modeControle_v,seuilDeclenchement_v, idRuche, idSensor) values 
(2, false, 'off', 33, 2, 2)  ;
insert into Ventilation (idVentilation, etat_v, modeControle_v, seuilDeclenchement_v,idRuche, idSensor) values   
(3, true,'on', 36, 3, 3);
insert into Ventilation (idVentilation, etat_v, modeControle_v,seuilDeclenchement_v, idRuche, idSensor) values 
(4, false, 'auto', 34, 4, 4)  ;
insert into Ventilation (idVentilation, etat_v, modeControle_v, seuilDeclenchement_v,idRuche, idSensor) values 
(5, true, 'auto', 37, 5, 5)  ;
insert into Ventilation (idVentilation, etat_v, modeControle_v,seuilDeclenchement_v, idRuche, idSensor) values 
(6, false, 'off', 32, 6, 6)  ;
insert into Ventilation (idVentilation, etat_v, modeControle_v,seuilDeclenchement_v, idRuche, idSensor) values
(7, true, 'on', 38, 7, 7)   ;
insert into Ventilation (idVentilation, etat_v, modeControle_v,seuilDeclenchement_v, idRuche, idSensor) values 
(8, false, 'auto', 35, 8, 8)  ;
insert into Ventilation (idVentilation, etat_v, modeControle_v,seuilDeclenchement_v, idRuche, idSensor) values 
(9, true, 'auto', 39, 9, 9)  ;
insert into Ventilation (idVentilation, etat_v, modeControle_v, seuilDeclenchement_v,idRuche, idSensor) values 
(10, false, 'off', 33, 10, 10)  ;


insert into Prise(idPrise, consommationW, etatPrise, idVentilation, idTapis, idBatterie) VALUES (1, 120.2, true, 1, NULL,1);
insert into Prise(idPrise, consommationW, etatPrise, idVentilation, idTapis, idBatterie) VALUES (2, 80.8, false, NULL, 2, 2);
insert into Prise(idPrise, consommationW, etatPrise, idVentilation, idTapis, idBatterie) VALUES (3, 150.3, true, 3, NULL, 3);
insert into Prise(idPrise, consommationW, etatPrise, idVentilation, idTapis, idBatterie) VALUES (4, 90.8, false, NULL, 4, 4);
insert into Prise(idPrise, consommationW, etatPrise, idVentilation, idTapis, idBatterie) VALUES (5, 110.6, true, 5, NULL, 5);
insert into Prise(idPrise, consommationW, etatPrise, idVentilation, idTapis, idBatterie) VALUES (6, 70.4, false, NULL, 6, 6);
insert into Prise(idPrise, consommationW, etatPrise, idVentilation, idTapis, idBatterie) VALUES (7, 130.1, true, 7, NULL, 7);
insert into Prise(idPrise, consommationW, etatPrise, idVentilation, idTapis, idBatterie) VALUES (8, 85.2, false, NULL, 8, 8);
insert into Prise(idPrise, consommationW, etatPrise, idVentilation, idTapis, idBatterie) VALUES (9, 140.9, true, 9, NULL, 9);
insert into Prise(idPrise, consommationW, etatPrise, idVentilation, idTapis, idBatterie) VALUES (10, 95.6, false, NULL, 10, 10);

insert into Lcd(idLcd, modeAffichage, derniereMAJ, idRuche, idSensor) values 
	(1, 'temperature', '2025-04-01', 1, 1);
insert into Lcd(idLcd, modeAffichage, derniereMAJ, idRuche, idSensor) values 
	(2, 'humidite', '2025-04-01', 2, 2);
insert into Lcd(idLcd, modeAffichage, derniereMAJ, idRuche, idSensor) values 
	(3, 'vibration', '2025-04-01', 3, 3);
insert into Lcd(idLcd, modeAffichage, derniereMAJ, idRuche, idSensor) values 
	(4, 'uv', '2025-04-02', 4, 4);
insert into Lcd(idLcd, modeAffichage, derniereMAJ, idRuche, idSensor) values 
	(5, 'nbPassage', '2025-04-02', 5, 5);
insert into Lcd(idLcd, modeAffichage, derniereMAJ, idRuche, idSensor) values 
	(6, 'etat', '2025-04-02', 6, 6);
insert into Lcd(idLcd, modeAffichage, derniereMAJ, idRuche, idSensor) values 
	(7, 'temperature', '2025-04-03', 7, 7);
insert into Lcd(idLcd, modeAffichage, derniereMAJ, idRuche, idSensor) values 
	(8, 'humidite', '2025-04-03', 8, 8);
insert into Lcd(idLcd, modeAffichage, derniereMAJ, idRuche, idSensor) values 
	(9, 'vibration', '2025-04-03', 9, 9);
insert into Lcd(idLcd, modeAffichage, derniereMAJ, idRuche, idSensor) values 
	(10, 'etat', '2025-04-03', 10, 10);

insert into Bouton (idBouton, nbAppuis, action, horodatage, idSensor, idLcd, idDoor) values (1, 2, 1, '2025-04-01', 1, 1, 1) ;
insert into Bouton (idBouton, nbAppuis, action, horodatage, idSensor, idLcd, idDoor) values (2, 3, 2, '2025-04-01', 2, 2, 2) ;
insert into Bouton (idBouton, nbAppuis, action, horodatage, idSensor, idLcd, idDoor) values (3, 1, 1, '2025-04-01', 3, 3, 3)  ;
insert into Bouton (idBouton, nbAppuis, action, horodatage, idSensor, idLcd, idDoor) values (4, 4, 3, '2025-04-02', 4, 4, 4);
insert into Bouton (idBouton, nbAppuis, action, horodatage, idSensor, idLcd, idDoor) values (5, 5, 2, '2025-04-02', 5, 5, 5);
insert into Bouton (idBouton, nbAppuis, action, horodatage, idSensor, idLcd, idDoor) values (6, 6, 1, '2025-04-02', 6, 6, 6);
insert into Bouton (idBouton, nbAppuis, action, horodatage, idSensor, idLcd, idDoor) values (7, 0, 3, '2025-04-03', 7, 7, 7);
insert into Bouton (idBouton, nbAppuis, action, horodatage, idSensor, idLcd, idDoor) values (8, 2, 2, '2025-04-03', 8, 8, 8);
insert into Bouton (idBouton, nbAppuis, action, horodatage, idSensor, idLcd, idDoor) values (9, 3, 1, '2025-04-03', 9, 9, 9);
insert into Bouton (idBouton, nbAppuis, action, horodatage, idSensor, idLcd, idDoor) values (10, 1, 2, '2025-04-03', 10, 10, 10);


insert into Contenir( idCommande, idProduit, quantitep ) VALUES (1, 1, 5);
insert into Contenir( idCommande, idProduit, quantitep ) VALUES (2, 2, 3);
insert into Contenir( idCommande, idProduit, quantitep ) VALUES (3, 3, 2);
insert into Contenir( idCommande, idProduit, quantitep ) VALUES (4, 4, 6);
insert into Contenir( idCommande, idProduit, quantitep ) VALUES (5, 5, 4);
insert into Contenir( idCommande, idProduit, quantitep ) VALUES (6, 6, 1);
insert into Contenir( idCommande, idProduit, quantitep ) VALUES (7, 7, 3);
insert into Contenir( idCommande, idProduit, quantitep ) VALUES (8, 8, 2);
insert into Contenir( idCommande, idProduit, quantitep ) VALUES (9, 9, 5);
insert into Contenir( idCommande, idProduit, quantitep ) VALUES (10, 10, 7);

insert into  Gerer( idUtilisateur ,idRuche) VALUES(1, 1);
insert into  Gerer( idUtilisateur ,idRuche) VALUES(2, 2);
insert into  Gerer( idUtilisateur ,idRuche) VALUES(3, 3);
insert into  Gerer( idUtilisateur ,idRuche) VALUES(4, 4);
insert into  Gerer( idUtilisateur ,idRuche) VALUES(5, 5);
insert into  Gerer( idUtilisateur ,idRuche) VALUES(6, 6);
insert into  Gerer( idUtilisateur ,idRuche) VALUES(7, 7);
insert into  Gerer( idUtilisateur ,idRuche) VALUES(8, 8);
insert into  Gerer( idUtilisateur ,idRuche) VALUES(9, 9);
insert into  Gerer( idUtilisateur ,idRuche) VALUES(10, 10);

insert into Historique(  idHistorique, typeEvenement, valeur , description, datedbt, datefin,idSensor, idPrise, idBouton, idTapis, idVentilation,idBalance) 
VALUES (1, 'temperature', 35.5, 'hausse critique', '2026-04-01', '2026-04-01', 1, NULL, NULL, NULL, NULL, NULL);
insert into Historique(  idHistorique, typeEvenement, valeur , description, datedbt, datefin,idSensor, idPrise, idBouton, idTapis, idVentilation,idBalance) 
VALUES (2, 'humidite', 60, 'taux normal', '2026-04-01', '2026-04-01', 1, NULL, NULL, NULL, NULL, NULL );
insert into Historique(  idHistorique, typeEvenement, valeur , description, datedbt, datefin,idSensor, idPrise, idBouton, idTapis, idVentilation,idBalance) 
VALUES (3, 'vibration', 0.8, 'activite forte', '2026-04-01', '2026-04-01', 2, NULL, NULL, NULL, NULL, NULL);
insert into Historique(  idHistorique, typeEvenement, valeur , description, datedbt, datefin,idSensor, idPrise, idBouton, idTapis, idVentilation,idBalance) 
VALUES (4, 'uv', 5, 'indice élevé', '2026-04-02', '2026-04-02', 1, NULL, NULL, NULL, NULL, NULL) ;
insert into Historique(  idHistorique, typeEvenement, valeur , description, datedbt, datefin,idSensor, idPrise, idBouton, idTapis, idVentilation,idBalance) 
VALUES (5, 'passage', 1200, 'fréquent', '2026-04-02', '2026-04-02', 1, NULL, NULL, NULL, NULL, NULL) ;
insert into Historique(  idHistorique, typeEvenement, valeur , description, datedbt, datefin,idSensor, idPrise, idBouton, idTapis, idVentilation,idBalance) 
VALUES (6, 'appui_bouton', 1, 'reset manuel', '2026-04-02', '2026-04-02', NULL, NULL, 1, NULL, NULL, NULL) ;
insert into Historique(  idHistorique, typeEvenement, valeur , description, datedbt, datefin,idSensor, idPrise, idBouton, idTapis, idVentilation,idBalance) 
VALUES (7, 'etat_tapis', 1, 'chauffage actif', '2026-04-02', '2026-04-03', NULL, NULL, NULL, 1, NULL, NULL);
insert into Historique(  idHistorique, typeEvenement, valeur , description, datedbt, datefin,idSensor, idPrise, idBouton, idTapis, idVentilation,idBalance) 
VALUES (8, 'etat_ventilation', 1, 'ventilation active', '2026-04-03', '2026-04-03', NULL, NULL, NULL, NULL, 1, NULL);
insert into Historique(  idHistorique, typeEvenement, valeur , description, datedbt, datefin,idSensor, idPrise, idBouton, idTapis, idVentilation,idBalance) 
VALUES (9, 'consommation', 12.5, 'conso stable Watts', '2026-04-03',' 2026-04-03', NULL, 1, NULL, NULL, NULL, NULL);
insert into Historique(  idHistorique, typeEvenement, valeur , description, datedbt, datefin,idSensor, idPrise, idBouton, idTapis, idVentilation,idBalance) 
VALUES (10, 'poids', 39.2, 'anomalie basse', '2026-04-04', '2026-04-04', NULL, NULL, NULL, NULL, NULL, 1);
