- 1. Cloner le répertoire dans /var/www/:

sudo git clone https://github.com/fabrice1618/trombinoscope.git /var/www/trombinoscope

- 2. Changer les droits du fichier trombinoscope:

sudo chown mathis:mathis /var/www/trombinoscope -R
- 3. Configurer le virtual host Apache:

Créez un fichier de configuration Apache pour le virtual host /etc/apache2/sites-available/trombinoscope.conf avec le contenu suivant :

<VirtualHost *:80>

    ServerName www.trombinoscope.local
    ServerAlias trombinoscope.local

    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/trombinoscope

    <Directory /var/www/trombinoscope>
        Require all granted
    </Directory>

    LogLevel info rewrite:trace8

    ErrorLog ${APACHE_LOG_DIR}/error.trombinoscope.log
    CustomLog ${APACHE_LOG_DIR}/access.trombinoscope.log combined

</VirtualHost>

- 4. Activer le virtual host et redémarrer Apache:

sudo ln -s /etc/apache2/sites-available/trombinoscope.conf /etc/apache2/sites-enabled/

sudo service apache2 restart

- 5. Modifier le fichier hosts sur le PC:
Ajoutez les lignes suivantes dans le fichier C:\Windows\System32\drivers\etc\hosts :

172.16.0.86     www.trombinoscope.local

172.16.0.86     trombinoscope.local

- 6. Créer la base de données:
Connectez-vous à votre serveur MySQL et exécutez les commandes suivantes :

CREATE DATABASE trombinoscope;
USE trombinoscope;

CREATE TABLE ma_table (
    nom VARCHAR(255),
    date VARCHAR(10),
    image LONGBLOB
);

INSERT INTO ma_table (nom, date, image)
VALUES
    ('John Doe', 'MMXXIII',test );