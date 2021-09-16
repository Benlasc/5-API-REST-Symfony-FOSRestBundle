<?php

namespace App\DataFixtures;

use App\Entity\SmartPhone;
use App\Entity\User;
use App\Entity\UserClient;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SmartPhonesFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        // Création des smartphones de l'API
        $phones = [
            "Apple" => [
                "Apple iPhone 12 (128 Go) - Vert" => [
                    "price" => "820.50",
                    "description" => "L'iPhone 12 est le modèle principal de la 14e génération de smartphone d'Apple annoncé le 13 octobre 2020. Il est équipé d'un écran de 6,1 pouces OLED HDR 60 Hz, d'un double capteur photo avec ultra grand-angle et d'un SoC Apple A14 Bionic compatible 5G (sub-6 GHz).",
                    "color" => "Vert",
                    "size" => 128,
                    "releaseDate" => "2020-10-23"
                ],
                "Apple iPhone 11 (64 Go) - Noir" => [
                    "price" => "589.00",
                    "description" => "L'iPhone 11 est le modèle le plus accessible de la douzième génération du célèbre smartphone d'Apple. Successeur direct de l'iPhone XR, il dispose d'un écran LCD de 6,1 pouces, un SoC Apple A13 Bionic et un double capteur photo arrière.",
                    "color" => "Noir",
                    "size" => 64,
                    "releaseDate" => "2019-09-20"
                ],
                "Apple iPhone SE 2020 (64 Go) - Noir" => [
                    "price" => "451.00",
                    "description" => "L'iPhone SE (2020) est le smartphone le moins cher d'Apple. Équipé du processeur A13 Bionic de l'iPhone 11, cet appareil reprend le design compact de l'iPhone 8 (4,7 pouces) et certaines de ses caractéristiques comme son capteur d'empreintes digitales Touch ID ou son appareil photo de 12 Mpix. Cet iPhone SE se destine aux personnes qui veulent un smartphone puissant, conçu pour durer, mais qui ne souhaitent pas investir un budget trop élevé.",
                    "color" => "Noir",
                    "size" => 64,
                    "releaseDate" => "2020-04-24"
                ]
            ],
            "Samsung" => [
                "Samsung Galaxy S21 (128 Go) - Gris" => [
                    "price" => "789.00",
                    "description" => "Le Samsung Galaxy S21 est le porte-étendard de la marque, succédant à la gamme S20. Il est équipé d'un SoC Exynos 2100 (gravé en 5 nm), d'une batterie de 4000 mAh et de 3 capteurs photo : le principal à 12 mégapixels, un capteur de 12 mégapixels et un téléobjectif de 64 mégapixels.",
                    "color" => "Gris",
                    "size" => 128,
                    "releaseDate" => "2020-01-29"
                ],
                "Samsung Galaxy S20 (128 Go) - Noir" => [
                    "price" => "615.00",
                    "description" => "Le Samsung Galaxy S20 est un smartphone haut de gamme de Samsung annoncé en février 2020 et disponible début mars 2020 qui succède au Galaxy S10. Il est équipé d'un écran AMOLED de 6,2 pouces certifié HDR10+, d'un triple capteur photo polyvalent entre ultra grand-angle et zoom 3X (30X en hybride) et d'un processeur Exynos 990 gravé en 7 nm épaulé par 8 Go de RAM (12 Go en version 5G). Il est disponible en version 4G ou 4G+5G et avec 128 Go de stockage UFS 3.0.",
                    "color" => "Noir",
                    "size" => 128,
                    "releaseDate" => "2020-02-11"
                ],
                "Samsung Galaxy A52 (64 Go) - Bleu" => [
                    "price" => "452.00",
                    "description" => "Le Samsung Galaxy A52 5G lancé en mars 2021 est doté d'un écran Amoled de 6.5 pouces, d'un processeur Snapdragon 750 appuyé par 6Go de RAM. Ce nouveau smartphone phare de la gamme A propose une solide fiche technique à prix abordable.",
                    "color" => "Bleu",
                    "size" => 64,
                    "releaseDate" => "2021-03-17"
                ],
            ],
            "Google" => [
                "Google Pixel 5 (128 Go) - Noir" => [
                    "price" => "629.00",
                    "description" => "Le Google Pixel 5 est un smartphone annoncé le 30 septembre 2020. Il s'agit du premier smartphone de Google a être compatible 5G et à disposer d'Android 11. Il est équipé d'un SoC Snapdragon 765G épaulé par 8 Go de RAM, d'un écran de 6 pouces OLED et d'un double capteur photo arrière avec ultra grand-angle.",
                    "color" => "Noir",
                    "size" => 128,
                    "releaseDate" => "2020-09-30"
                ],
                "Google Pixel 4 (64 Go) - Noir" => [
                    "price" => "364.00",
                    "description" => "Le Google Pixel 4 est un smartphone haut de gamme annoncé par Google le 15 octobre 2019. Il est équipé d'un double capteur avec un très puissant traitement logiciel, d'un SoC Qualcomm Snapdragon 855 épaulé par 6 Go de RAM et d'un écran OLED de 5,7 pouces en full HD+.",
                    "color" => "Noir",
                    "size" => 64,
                    "releaseDate" => "2019-10-24"
                ],
                "Google Pixel 4a (128 Go) - Vert" => [
                    "price" => "349.00",
                    "description" => "Le Google Pixel 4a est un smartphone milieu de gamme équipé d'un SoC Qualcomm Snapdragon 730G, épaulé par 6 Go de RAM et 128 Go de stockage, non extensible. Il bénéficie d'un capteur photo principal de 12.2 mégapixels. Il possède une batterie de 3140 mAh rechargeable via son port USB C et d'un port jack.",
                    "color" => "Vert",
                    "size" => 128,
                    "releaseDate" => "2020-10-01"
                ],
            ],
        ];

        foreach ($phones as $brand => $phone) {
            foreach ($phone as $model => $modelInformations) {
                $smartPhone = new SmartPhone();

                // On enregistre chaque téléphone dans un tableau
                $smartPhones[] = $smartPhone;
                $smartPhone->setBrand($brand)
                    ->setModel($model)
                    ->setDescription($modelInformations['description'])
                    ->setColor($modelInformations['color'])
                    ->setPrice($modelInformations['price'])
                    ->setReleaseDate(new DateTime($modelInformations['releaseDate']))
                    ->setSize($modelInformations['size']);
                $manager->persist($smartPhone);
            }
        }

        // Création des entreprises et leurs clients
        $users = [
            "Kawa Mobiles" =>
            [
                "email" => "kawaMobile@domain.com",
                "roles" => ["ROLE_USER"],
                "password" => "kawapass",
                "token" => "gxu7Z2HpuDlxXLLMuBZj",
                "userClients" => [
                    [
                        "first_name" => "Paul",
                        "last_name" => "Durant",
                        "email" => "PaulDurant@mail.fr",
                        "login" => "Polo87"
                    ],
                    [
                        "first_name" => "Sarah",
                        "last_name" => "Duffet",
                        "email" => "Sarahcroche@domain.com",
                        "login" => "SaphireMoon"
                    ],
                    [
                        "first_name" => "Julien",
                        "last_name" => "Loiseau",
                        "email" => "juju@mdomain.fr",
                        "login" => "BlueVif"
                    ],
                ]
            ],
            "Dual Tech" =>
            [
                "email" => "DualTechno@domain.fr",
                "roles" => ["ROLE_USER"],
                "password" => "dualpass",
                "token" => "VzQyoPxDfbgXzXTpFobU",
                "userClients" => [
                    [
                        "first_name" => "Christiane",
                        "last_name" => "Grimard",
                        "email" => "ChristianeGrimard@mail.fr",
                        "login" => "ChrisGd"
                    ],
                    [
                        "first_name" => "Isaac",
                        "last_name" => "Briand",
                        "email" => "IsaacB@domain.fr",
                        "login" => "Isaac87"
                    ],
                    [
                        "first_name" => "Catherine",
                        "last_name" => "Maillet",
                        "email" => "CatherineMaillet@mdomain.fr",
                        "login" => "Cathy"
                    ],
                ]
            ],
            "Aqua Phone" =>
            [
                "email" => "aquaPhone@domain.com",
                "roles" => ["ROLE_USER"],
                "password" => "aquapass",
                "token" => "HgvF75U7tVH1K8Mou1UJ",
                "userClients" => [
                    [
                        "first_name" => "Zacharie",
                        "last_name" => "Mahe",
                        "email" => "ZacharieMahe@mail.com",
                        "login" => "ZacharieM"
                    ],
                    [
                        "first_name" => "Frédéric",
                        "last_name" => "Masson",
                        "email" => "massonFred@domain.com",
                        "login" => "Fred"
                    ],
                    [
                        "first_name" => "Colette",
                        "last_name" => "Vallet",
                        "email" => "valletColette@mdomain.fr",
                        "login" => "CocoVal"
                    ],
                ]
            ],
        ];

        foreach ($users as $userName => $userInformations) {
            $newUser = new User();
            $passWord = $userInformations['password'];
            $newUser->setName($userName)
                    ->setEmail($userInformations['email'])
                    ->setPassword($this->encoder->hashPassword($newUser, $passWord))
                    ->setRoles($userInformations['roles'])
                    ->setToken($userInformations['token']);
            foreach ($userInformations['userClients'] as $userClient) {
                $newUserClient = new UserClient();
                $newUserClient->setFirstName($userClient["first_name"])
                              ->setLastName($userClient["last_name"])
                              ->setEmail($userClient["email"])
                              ->setLogin($userClient["login"]);
                $newUser->addUserClient($newUserClient);
            }

            // On attribue tous les smartphones au premier utilisateur de l'API
            if ($userName == "Kawa Mobiles") {
                foreach ($smartPhones as $smartPhone) {
                    $newUser->addSmartPhone($smartPhone);
                }
            } else {
                // On attribue aléatoirement 6 smartphones aux autres utilisateurs de l'API
                $randomKeys = array_rand($smartPhones, 6);
                foreach ($randomKeys as $key) {
                    $newUser->addSmartPhone($smartPhones[$key]);
                }
            }

            $manager->persist($newUser);
        }
        $manager->flush();
    }
}
