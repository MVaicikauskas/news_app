# NewsApp - Laravel News Portal

Welcome to NewsApp! This is a modern news portal built with Laravel, Inertia.js (Vue 3), and Tailwind CSS. It features secure data encryption with CipherSweet, role-based access control with Spatie Permission, and a smooth user experience.

This guide will help you get the project up and running on your local machine, even if you are just starting with Laravel development.

---

## 🛠 Prerequisites

Before you begin, ensure you have the following installed on your system:

*   **PHP (8.4.16 or higher)**
*   **Composer (2.4.1 or higher)** (PHP dependency manager)
*   **Node.js (v20.19.0 or higher)**
*   **NPM (10.8.2 or higher)** (for frontend assets)
*   **MySQL or MariaDB** (database)
*   **Git** (optional, for cloning)

---

## 🚀 Installation Steps

Follow these steps one by one to set up the project.

### 1. Clone or Download the Project
If you have Git installed, run:
```bash
git clone <repository-url>
cd news_app
```
Otherwise, download the ZIP file and extract it to your local server folder (e.g., `C:\laragon\www\news_app`).

### 2. Install PHP Dependencies
Open your terminal in the project root and run:
```bash
composer install
```

### 3. Install Frontend Dependencies
Run the following command to install all necessary JavaScript packages:
```bash
npm install
```

### 4. Setup Environment Configuration
Copy the `.env.example` file to create your own `.env` file:
```bash
cp .env.example .env
```
*(On Windows PowerShell: `copy .env.example .env`)*

Open the `.env` file in a text editor and update your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=news_app
DB_USERNAME=root
DB_PASSWORD=
```
*Make sure you have created an empty database named `news_app` in your MySQL server.*

### 5. Generate Application Key
Run this command to generate a unique key for your application:
```bash
php artisan key:generate
```

### 6. Setup CipherSweet Encryption Key
This project uses CipherSweet to encrypt sensitive user data (like emails). You need to generate a key for it:
```bash
php artisan ciphersweet:generate-key
```
Copy the generated key and paste it into your `.env` file:
```env
CIPHERSWEET_KEY=your_generated_key_here
```

### 7. Run Database Migrations & Seeding
This command will create all the necessary tables and fill them with sample data (users, roles, and posts):
```bash
php artisan migrate:fresh --seed
```

### 8. Link Storage
To make images visible on the website, you need to create a symbolic link from the storage folder to the public folder:
```bash
php artisan storage:link
```

---

## 🏃 Running the Application

To see the website in your browser, you need to have two processes running in your terminal:

1.  **Start the PHP Server:**
    ```bash
    php artisan serve
    ```
    This will start the app at `http://127.0.0.1:8000`.

2.  **Start Vite (for Frontend):**
    Open a *new* terminal window in the same project folder and run:
    ```bash
    npm run dev
    ```

Now, open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your web browser!

---

## 🔐 Default User Credentials

After seeding the database, you can use these accounts to test different roles:

### Admin User (Full Access)
*   **Email:** `admin@example.com`
*   **Password:** `password`

### Author User (Can create/edit posts)
*   **Email:** `author@example.com`
*   **Password:** `password`

---

## 📂 Project Structure Overview

*   `app/Models`: Database models with column constants for better maintainability.
*   `app/Services`: Business logic separated from controllers.
*   `app/Repositories`: Database query logic.
*   `resources/js/Pages`: Frontend views built with Vue 3 and Inertia.js.
*   `lang/lt`: Lithuanian translations for the application.

---

## 📝 Common Commands

*   `php artisan migrate:fresh --seed` - Resets database and reloads sample data.
*   `npm run build` - Builds the frontend for production.
*   `php artisan route:list` - See all available web routes.

Happy Coding! 🚀

---

# NewsApp - „Laravel“ Naujienų Portalas

Sveiki atvykę į „NewsApp“! Tai modernus naujienų portalas, sukurtas naudojant „Laravel“, „Inertia.js“ („Vue 3“) ir „Tailwind CSS“. Jame įdiegtas saugus duomenų šifravimas su „CipherSweet“, vaidmenimis pagrįsta prieigos kontrolė („Spatie Permission“) ir sklandi vartotojo patirtis.

Šis gidas padės jums įdiegti ir paleisti projektą savo vietinėje mašinoje, net jei tik pradedate dirbti su „Laravel“.

---

## 🛠 Reikalavimai

Prieš pradedant įsitikinkite, kad jūsų sistemoje įdiegta:

*   **PHP (8.4.16 arba naujesnė)**
*   **Composer (2.4.1 arba naujesnė)** (PHP priklausomybių valdiklis)
*   **Node.js (v20.19.0 arba naujesnė)**
*   **NPM (10.8.2 arba naujesnė)** (frontend turtui)
*   **MySQL arba MariaDB** (duomenų bazė)
*   **Git** (nebūtina, klonavimui)

---

## 🚀 Diegimo žingsniai

Atlikite šiuos veiksmus iš eilės, kad paruoštumėte projektą.

### 1. Klonuokite arba atsisiųskite projektą
Jei turite įdiegtą „Git“, paleiskite:
```bash
git clone <repository-url>
cd news_app
```
Kitu atveju atsisiųskite ZIP failą ir išpakuokite jį į savo vietinio serverio aplanką (pvz., `C:\laragon\www\news_app`).

### 2. Įdiekite PHP priklausomybes
Atidarykite terminalą projekto aplanke ir paleiskite:
```bash
composer install
```

### 3. Įdiekite Frontend priklausomybes
Paleiskite šią komandą, kad įdiegtumėte visus reikiamus „JavaScript“ paketus:
```bash
npm install
```

### 4. Aplinkos konfigūracijos nustatymas
Nukopijuokite `.env.example` failą ir sukurkite savo `.env` failą:
```bash
cp .env.example .env
```
*(„Windows PowerShell“ aplinkoje: `copy .env.example .env`)*

Atidarykite `.env` failą tekstų redaktoriumi ir atnaujinkite duomenų bazės prisijungimus:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=news_app
DB_USERNAME=root
DB_PASSWORD=
```
*Įsitikinkite, kad savo „MySQL“ serveryje sukūrėte tuščią duomenų bazę pavadinimu `news_app`.*

### 5. Sugeneruokite programos raktą
Paleiskite šią komandą, kad sugeneruotumėte unikalų raktą savo programai:
```bash
php artisan key:generate
```

### 6. „CipherSweet“ šifravimo rakto nustatymas
Šis projektas naudoja „CipherSweet“, kad užšifruotų jautrius vartotojo duomenis (pvz., el. paštą). Tam reikia sugeneruoti raktą:
```bash
php artisan ciphersweet:generate-key
```
Nukopijuokite sugeneruotą raktą ir įklijuokite jį į savo `.env` failą:
```env
CIPHERSWEET_KEY=jusu_sugeneruotas_raktas_cia
```

### 7. Duomenų bazės migracijų ir pradinių duomenų vykdymas
Ši komanda sukurs visas reikiamas lenteles ir užpildys jas pavyzdiniais duomenimis (vartotojais, vaidmenimis ir įrašais):
```bash
php artisan migrate:fresh --seed
```

### 8. Saugyklos susiejimas (Storage Link)
Kad nuotraukos būtų matomos svetainėje, turite sukurti simbolinę nuorodą iš „storage“ aplanko į „public“ aplanką:
```bash
php artisan storage:link
```

---

## 🏃 Programos paleidimas

Norėdami pamatyti svetainę savo naršyklėje, terminale turi veikti du procesai:

1.  **Paleiskite PHP serverį:**
    ```bash
    php artisan serve
    ```
    Tai paleis programą adresu `http://127.0.0.1:8000`.

2.  **Paleiskite „Vite“ (Frontend daliai):**
    Atidarykite *naują* terminalo langą tame pačiame projekto aplanke ir paleiskite:
    ```bash
    npm run dev
    ```

Dabar naršyklėje atidarykite [http://127.0.0.1:8000](http://127.0.0.1:8000)!

---

## 🔐 Numatytieji vartotojo duomenys

Užpildę duomenų bazę, galite naudoti šias paskyras skirtingiems vaidmenims išbandyti:

### Administratorius (Pilna prieiga)
*   **El. paštas:** `admin@example.com`
*   **Slaptažodis:** `password`

### Autorius (Gali kurti/redaguoti įrašus)
*   **El. paštas:** `author@example.com`
*   **Slaptažodis:** `password`

---

## 📂 Projekto struktūros apžvalga

*   `app/Models`: Duomenų bazės modeliai su stulpelių konstantomis geresniam palaikymui.
*   `app/Services`: Verslo logika, atskirta nuo valdiklių (controllers).
*   `app/Repositories`: Duomenų bazės užklausų logika.
*   `resources/js/Pages`: Frontend vaizdai, sukurti naudojant „Vue 3“ ir „Inertia.js“.
*   `lang/lt`: Lietuviški vertimai programai.

---

## 📝 Dažnos komandos

*   `php artisan migrate:fresh --seed` - Ištrina duomenų bazę ir įkelia pavyzdinius duomenis iš naujo.
*   `npm run build` - Paruošia frontend dalį gamybinei (production) aplinkai.
*   `php artisan route:list` - Peržiūrėti visus galimus svetainės kelius (routes).

Sėkmingo kodavimo! 🚀
