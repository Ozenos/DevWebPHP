    <?php

$tableau = [
    [
        "title" => "Dysfonctionnement de l’export PDF",
        "time" => 2,
        "advancement" => "En cours",
        "facturation" => "Inclus",
        "collaborators" => ["Vous", "Alice Martin", "Lucas Bernard", "Sofia Dupont"]
    ],
    [
        "title" => "Désinstallation",
        "time" => 2,
        "advancement" => "En cours",
        "facturation" => "Inclus",
        "collaborators" => ["Vous", "Alice Martin", "Lucas Bernard", "Sofia Dupont"]
    ],
    [
        "title" => "DESTRUCTION",
        "time" => 1,
        "advancement" => "En cours",
        "facturation" => "Facturable",
        "collaborators" => [
            "Vous",
            "Alice Martin",
            "Lucas Bernard",
            "Sofia Dupont",
            "Le prof",
            "L'école",
            "Le pays",
            "Le monde"
        ]
    ],
    [
        "title" => "DESTRUCTION ABSOLUE",
        "time" => 20,
        "advancement" => "Terminé",
        "facturation" => "Facturable",
        "collaborators" => ["L'existence même", "Vous"]
    ],
    [
        "title" => "Another one",
        "time" => 0,
        "advancement" => "Ouvert",
        "facturation" => "Facturable",
        "collaborators" => ["Vous"]
    ],
    [
        "title" => "Titre",
        "time" => 0,
        "advancement" => "Ouvert",
        "facturation" => "Inclus",
        "tags" => ["inclus", "ouvert"],
        "collaborators" => ["Vous seulement !"]
    ],
    [
        "title" => "Finale des Worlds",
        "time" => 13,
        "advancement" => "Terminé",
        "facturation" => "Inclus",
        "collaborators" => ["Vous seulement !"]
    ]
];

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1c1917',   //stone-900
                        secondary: '#f3f4f6', //gray-100
                        tertiary: '#e5e7eb',  //gray-200
                        accent: '#57534e',    //stone-600
                        background: '#FFFFFF',
                        text: '#030712',      //gray-950
                        footertext: "#a8a29e" //stone-400
                    },
                },
            },
        };
    </script>
    <script src="listTicket.js" defer></script>
    <title>Cross Tickets - Tickets</title>
    <link rel="shortcut icon" href="Ticket.jpg" />
</head>

<body class="min-h-screen bg-secondary">

    <!-- Bandeau supérieur -->
    <header class="fixed top-0 left-0 right-0 h-14 bg-background shadow flex items-center justify-between px-6 z-20">
        <div class="flex items-center gap-4">
            <button class="text-text hover:text-footertext">
                ☰
            </button>
            <a href="dashboard.html" class="font-semibold text-text">Dashboard</a>
        </div>

        <div class="flex items-center gap-4 text-sm">
            <a href="#" class="text-accent">Jean Dupont</a>
            <a href="connexion.html"
                class="bg-primary text-white p-2 rounded-lg font-semibold hover:bg-accent transition">
                Déconnexion
            </a>
        </div>
    </header>

    <div class="flex pt-14 min-h-screen">

        <!-- Bandeau gauche -->
        <aside class="w-64 bg-background shadow-lg p-6 space-y-6">
            <div class="space-y-6">
                <!-- Facturation -->
                <div>
                    <h2 class="text-md font-semibold text-accent uppercase mb-3">
                        Facturation
                    </h2>
                    <div class="flex flex-col gap-2">
                        <div class="px-3 py-2 rounded-md border border-tertiary bg-lime-100">
                            <input type="checkbox" data-filter="inclus" class="hover:bg-secondary focus:outline-none">
                            <span class="text-md text-lime-700">Inclus</span>
                        </div>
                        <div class="px-3 py-2 rounded-md border border-tertiary bg-yellow-100">
                            <input type="checkbox" data-filter="facturable"
                                class="hover:bg-secondary focus:outline-none">
                            <span class="text-md text-yellow-700">Facturable</span>
                        </div>
                    </div>
                </div>

                <!-- Avancement -->
                <div>
                    <h2 class="text-md font-semibold text-accent uppercase mb-3">
                        Avancement
                    </h2>
                    <div class="flex flex-col gap-2">
                        <div class="px-3 py-2 rounded-md border border-tertiary bg-blue-100">
                            <input type="checkbox" data-filter="ouvert" class="hover:bg-secondary focus:outline-none">
                            <span class="text-md text-blue-700">Ouvert</span> 
                        </div>
                        <div class="px-3 py-2 rounded-md border border-tertiary bg-orange-100 ">
                            <input type="checkbox" data-filter="cours" class="hover:bg-secondary focus:outline-none">
                            <span class="text-md text-orange-700">En cours</span>
                        </div>
                        <div class="px-3 py-2 rounded-md border border-tertiary bg-lime-100 ">
                            <input type="checkbox" data-filter="termine" class="hover:bg-secondary focus:outline-none">
                            <span class="text-md text-lime-700">Terminé</span>
                        </div> 
                    </div>
                </div>
            </div>
        </aside>

        <div class="mt-5 grid
            grid-cols-[repeat(auto-fill,340px)]
            justify-center gap-6
            w-full min-w-0 py-4">
            <?php foreach ($tableau as $ticket): ?>
            <div class="ticket bg-background rounded-xl shadow-lg p-8 space-y-6 w-[340px] max-w-[340px] self-start">

                <!-- En-tête -->
                <div class="flex justify-center">
                    <h1 class="text-2xl font-bold text-text text-center">
                        <?= htmlspecialchars($ticket["title"]) ?>
                    </h1>
                </div>

                <!-- Temps passé -->
                <div class="flex mb-2 justify-between gap-2">
                    <div>
                        <h2 class="text-sm font-semibold text-accent">
                            Temps passé
                        </h2>
                        <p class="text-text">
                            <?= $ticket["time"] ?> heure<?= $ticket["time"] > 1 ? "s" : "" ?>
                        </p>
                    </div>

                    <div class="text-right">
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full">
                            <?= $ticket["advancement"] ?>
                        </span>
                        <span class="inline-block px-3 mt-1 py-1 text-sm font-semibold rounded-full">
                            <?= $ticket["facturation"] ?>
                        </span>
                    </div>
                </div>

                <!-- Propriétaire et Collaborateurs -->
                <div>
                    <h2 class="text-sm font-semibold text-accent mb-2">
                        Propriétaire et collaborateurs
                    </h2>
                    <ul class="flex gap-2 flex-wrap">
                        <?php foreach ($ticket["collaborators"] as $collaborator): ?>
                            <li class="px-3 py-1 text-sm rounded-full bg-secondary text-text">
                                <?= htmlspecialchars($collaborator) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>
<?php endforeach; ?>

        </div>
    </div>
</body>

</html>