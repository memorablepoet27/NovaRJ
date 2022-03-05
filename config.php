<?php


// Define o Titulo das Paginas
$cfg['title'] = 'NoxCity - Roleplay';




$cfgOrg = '[
  {"nome":"MotoClub","set":"Motoclub", "bau": "Motoclub"},
  {"nome":"Mafia","set":"Mafia", "bau": "MAFIAG"},
  {"nome":"Vagos","set":"Vagos", "bau": "Vagos"},
  {"nome":"Ballas","set":"Ballas", "bau": "Ballas"},
  {"nome":"Vanilla Unicorn","set":"iunicorn", "bau": "iunicorn"},
  {"nome":"Families","set":"Families", "bau": "Families"},
  {"nome":"Nuestra","set":"Nuestra", "bau": "Triad"},
  {"nome":"Policia NPD","set":"Policia", "bau": "Policia"},
  {"nome":"Mecanico","set":"Mecanico", "bau": "Mecanico"},
  {"nome":"Paramedico EMS","set":"Paramedico", "bau": "Paramedico"},
  {"nome":"Juiza","set":"Juiza", "bau": "Juiza"},
  {"nome":"Advogado","set":"Advogado", "bau": "Advogado"},
  {"nome":"[GOD] Admin","set":"Admin", "bau": "Admin"},
  {"nome":"[GOD] Moderador","set":"Mod\':true", "bau": "Mod"},
  {"nome":"[GOD] Suporte","set":"Suporte", "bau": "Suporte"}
]';

/* PROFISSOES DESATIVADAS
{"nome":"Serpentes","set":"Serpentes"},
{"nome":"Yakuza","set":"Yakuza"},
{"nome":"Reporter","set":"Reporter"},
{"nome":"News","set":"News"},
{"nome":"Concessionaria","set":"Concessionaria"},
{"nome":"Vendedor","set":"Vendedor"}
*/

$cfgItemHack = '{
  "WEAPON_MICROSMG\'": {"nome":"Uzi (HACK)"},
  "WEAPON_PETROLCAN\'": {"nome":"WEAPON_PETROLCAN"},
  "WEAPON_HEAVYSNIPER\'": {"nome":"WEAPON_HEAVYSNIPER"},
  "WEAPON_PISTOL50\'": {"nome":"WEAPON_PISTOL50"},
  "WEAPON_RPG\'": {"nome":"WEAPON_RPG"},
  "WEAPON_HEAVYSHOTGUN\'": {"nome":"WEAPON_HEAVYSHOTGUN"},
  "WEAPON_HEAVYPISTOL\'": {"nome":"WEAPON_HEAVYPISTOL"},
  "WEAPON_GRENADELAUNCHER_SMOKE\'": {"nome":"WEAPON_GRENADELAUNCHER_SMOKE"},
  "WEAPON_ASSAULTSHOTGUN\'": {"nome":"WEAPON_ASSAULTSHOTGUN"},
  "WEAPON_APPISTOL\'": {"nome":"WEAPON_APPISTOL"},
  "WEAPON_BULLPUPSHOTGUN\'": {"nome":"WEAPON_BULLPUPSHOTGUN"},
  "WEAPON_MG\'": {"nome":"WEAPON_MG"},
  "WEAPON_COMBATMG\'": {"nome":"WEAPON_COMBATMG"},
  "WEAPON_SPECIALCARBINE\'": {"nome":"WEAPON_SPECIALCARBINE"},
  "WEAPON_VINTAGEPISTOL\'": {"nome":"WEAPON_VINTAGEPISTOL"},
  "WEAPON_SNSPISTOL\'": {"nome":"WEAPON_SNSPISTOL"},
  "WEAPON_BALL\'": {"nome":"WEAPON_BALL"},
  "WEAPON_FLAREGUN\'": {"nome":"WEAPON_FLAREGUN"},
  "WEAPON_MICROSMG\'": {"nome":"WEAPON_MICROSMG"},
  "WEAPON_SAWNOFFSHOTGUN\'": {"nome":"WEAPON_SAWNOFFSHOTGUN"},
  "WEAPON_ADVANCEDRIFLE\'": {"nome":"WEAPON_ADVANCEDRIFLE"},
  "WEAPON_BULLPUPRIFLE\'": {"nome":"WEAPON_BULLPUPRIFLE"},
  "WEAPON_REVOLVER\'": {"nome":"WEAPON_REVOLVER"},
  "WEAPON_SNIPERRIFLE\'": {"nome":"WEAPON_SNIPERRIFLE"}  
}';

$cfgItemSearch = '{
  "dinheirosujo\'": {"nome":"Dinheiro Sujo"},
  "wbody|WEAPON_COMBATPISTOL\'": {"nome":"Glock (POLICIA)"},
  "wbody|WEAPON_SMG\'": {"nome":"MP5 (POLICIA)"},
  "wbody|WEAPON_CARBINERIFLE\'": {"nome":"M4A1 (POLICIA)"},
  "wbody|WEAPON_COMBATPDW\'": {"nome":"SigSauer (POLICIA)"},
  "wbody|WEAPON_STUNGUN\'": {"nome":"Taser (POLICIA)"},
  "wbody|WEAPON_PISTOL_MK2\'": {"nome":"Five7"},
  "wbody|WEAPON_ASSAULTSMG\'": {"nome":"Mtar"},
  "wbody|WEAPON_ASSAULTRIFLE\'": {"nome":"Ak103"},
  "wbody|WEAPON_MACHINEPISTOL\'": {"nome":"Tec9"},
  "wbody|WEAPON_STUNGUN\'": {"nome":"Taser (POLICIA)"},
  "wammo|WEAPON_PUMPSHOTGUN\'": {"nome":"Mun. Shotgun"},
  "wbody|WEAPON_MICROSMG\'": {"nome":"Uzi (HACK)"}
  }';



$cfgItem = '{
  "wbody|GADGET_PARACHUTE": {"nome":"Paraquedas", "icon":"paraquedas"},
  "wbody|WEAPON_DAGGER": {"nome":"Adaga", "icon":"adaga"},
  "wbody|WEAPON_BAT": {"nome":"Taco de Beisebol", "icon":"beisebol"},
  "wbody|WEAPON_BOTTLE": {"nome":"Garrafa", "icon":"garrafa"},
  "wbody|WEAPON_CROWBAR": {"nome":"Pé de Cabra", "icon":"cabra"},
  "wbody|WEAPON_FLASHLIGHT": {"nome":"Lanterna", "icon":"lanterna"},
  "wbody|WEAPON_GOLFCLUB": {"nome":"Taco de Golf", "icon":"golf"},
  "wbody|WEAPON_HAMMER": {"nome":"Martelo", "icon":"martelo"},
  "wbody|WEAPON_HATCHET": {"nome":"Machado", "icon":"machado"},
  "wbody|WEAPON_KNUCKLE": {"nome":"Soco-Ingles", "icon":"ingles"},
  "wbody|WEAPON_KNIFE": {"nome":"Faca", "icon":"faca"},
  "wbody|WEAPON_MACHETE": {"nome":"Machete", "icon":"machete"},
  "wbody|WEAPON_SWITCHBLADE": {"nome":"Canivete", "icon":"canivete"},
  "wbody|WEAPON_NIGHTSTICK": {"nome":"Cassetete", "icon":"cassetete"},
  "wbody|WEAPON_WRENCH": {"nome":"Chave de Grifo", "icon":"grifo"},
  "wbody|WEAPON_BATTLEAXE": {"nome":"Machado de Batalha", "icon":"batalha"},
  "wbody|WEAPON_POOLCUE": {"nome":"Taco de Sinuca", "icon":"sinuca"},
  "wbody|WEAPON_STONE_HATCHET": {"nome":"Machado de Pedra", "icon":"pedra"},

  "WEAPON_STUNGUN": {"nome":"Taser", "icon":"taser"},
  "wbody|WEAPON_PISTOL": {"nome":"M1911", "icon":"m1911"},
  "wbody|WEAPON_COMBATPISTOL": {"nome":"Glock", "icon":"glock"},
  "wbody|WEAPON_PISTOL_MK2": {"nome":"Five7", "icon":"fiveseven"},
  "wbody|WEAPON_MACHINEPISTOL": {"nome":"Tec-9", "icon":"tec9"},
  "wbody|WEAPON_STUNGUN": {"nome":"Taser", "icon":"taser"},

  "wbody|WEAPON_PUMPSHOTGUN": {"nome":"Shotgun", "icon":"shotgun"},
  "wbody|WEAPON_PUMPSHOTGUN_MK2": {"nome":"Remington 870", "icon":"remington"},
  "wbody|WEAPON_SMG": {"nome":"MP5", "icon":"mp5"},
  "wbody|WEAPON_ASSAULTSMG": {"nome":"MTAR21", "icon":"mtar21"},
  "wbody|WEAPON_GUSENBERG": {"nome":"Thompson", "icon":"thompson"},
  "wbody|WEAPON_COMBATPDW": {"nome":"SigSauer", "icon":"sigsauer"},

  "wbody|WEAPON_CARBINERIFLE": {"nome":"M4A1", "icon":"m4a1"},
  "wbody|WEAPON_ASSAULTRIFLE": {"nome":"AK103", "icon":"ak103"},
  "wbody|WEAPON_COMPACTRIFLE": {"nome":"AKs", "icon":"aks"},
  "wbody|WEAPON_CARBINERIFLE_MK2": {"nome":"MPx", "icon":"mpx"},

  "wammo|WEAPON_PISTOL": {"nome":"Mun. M1911", "icon":"m-m1911"},
  "wammo|WEAPON_COMBATPISTOL": {"nome":"Mun. Glock", "icon":"m-glock"},
  "wammo|WEAPON_PISTOL_MK2": {"nome":"Mun. Five7", "icon":"m-fiveseven"},
  "wammo|WEAPON_MACHINEPISTOL": {"nome":"Mun. Tec-9", "icon":"m-tec9"},
  "wammo|WEAPON_PUMPSHOTGUN": {"nome":"Mun. Shotgun", "icon":"m-shotgun"},
  "wammo|WEAPON_PUMPSHOTGUN_MK2": {"nome":"Mun. Remington 870", "icon":"m-remington"},
  "wammo|WEAPON_SMG": {"nome":"Mun. MP5", "icon":"m-mp5"},
  "wammo|WEAPON_ASSAULTSMG": {"nome":"Mun. MTAR21", "icon":"m-mtar21"},
  "wammo|WEAPON_GUSENBERG": {"nome":"Mun. Thompson", "icon":"m-thompson"},
  "wammo|WEAPON_COMBATPDW": {"nome":"Mun; SigSauer", "icon":"m-sigsauer"},
  "wammo|WEAPON_CARBINERIFLE": {"nome":"Mun. M4A1", "icon":"m-m4a1"},
  "wammo|WEAPON_ASSAULTRIFLE": {"nome":"Mun. AK103", "icon":"m-ak103"},
  "wammo|WEAPON_COMPACTRIFLE": {"nome":"Mun. AKs", "icon":"m-aks"},
  "wammo|WEAPON_CARBINERIFLE_MK2": {"nome":"Mun. MPx", "icon":"m-mpx"}
  }';



$cfgVeiculo = '{

}';

?>
