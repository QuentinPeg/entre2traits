const fs = require('fs').promises;
const path = require('path');

// Chemin du dossier contenant vos fichiers CSS
const cssDir = './manager';
const outputFile = './style_manager.css';
const specificDir = './manag/'; // Dossier pour les fichiers spécifiques

// Fonction pour lire les fichiers CSS
async function readCSSFiles(directory) {
    const files = await fs.readdir(directory);
    const cssFiles = files.filter(file => file.endsWith('.css'));
    const fileContents = await Promise.all(
        cssFiles.map(async file => ({
            name: file,
            content: await fs.readFile(path.join(directory, file), 'utf-8'),
        }))
    );
    return fileContents;
}

// Fonction pour parser les règles CSS avec normalisation
function parseRules(content) {
    const ruleRegex = /([^{]+)\{([^}]+)\}/g; // Regex pour extraire les blocs CSS
    const rules = [];
    let match;

    while ((match = ruleRegex.exec(content)) !== null) {
        const selector = match[1].trim();
        const properties = match[2]
            .split(';') // Séparer chaque propriété
            .map(prop => prop.trim()) // Supprimer les espaces autour
            .filter(Boolean) // Ignorer les lignes vides
            .sort() // Trier pour éviter les différences d'ordre
            .join('; '); // Reconstituer une chaîne normalisée
        rules.push({ selector, properties });
    }

    return rules;
}

// Fusionner les règles communes
function extractCommonRules(filesContent, threshold = 2) {
    const rulesMap = new Map();

    filesContent.forEach(({ content }) => {
        const rules = parseRules(content);

        rules.forEach(({ selector, properties }) => {
            const key = `${selector} { ${properties} }`;
            rulesMap.set(key, (rulesMap.get(key) || 0) + 1);
        });
    });

    // Conserver les règles présentes dans au moins `threshold` fichiers
    const commonRules = Array.from(rulesMap.entries())
        .filter(([, count]) => count >= threshold) // Règles apparaissant au moins `threshold` fois
        .map(([rule]) => rule);

    return commonRules.join('\n');
}

// Générer des fichiers spécifiques avec les règles restantes
async function generateSpecificFiles(filesContent, commonRules) {
    const commonSelectors = new Set(
        commonRules.map(rule => rule.match(/([^{]+)\{/)[1].trim())
    );

    // Créer le dossier pour les fichiers spécifiques s'il n'existe pas
    await fs.mkdir(specificDir, { recursive: true });

    await Promise.all(
        filesContent.map(async ({ name, content }) => {
            const rules = parseRules(content);
            const specificRules = rules.filter(({ selector }) => !commonSelectors.has(selector));
            const specificCSS = specificRules
                .map(({ selector, properties }) => `${selector} { ${properties} }`)
                .join('\n');

            // Écrire les règles spécifiques dans un fichier
            if (specificCSS) {
                const specificPath = path.join(specificDir, name);
                await fs.writeFile(specificPath, specificCSS);
                console.log(`Fichier spécifique généré : ${specificPath}`);
            }
        })
    );
}

// Fonction principale
async function main() {
    try {
        // Lire et traiter les fichiers CSS
        const filesContent = await readCSSFiles(cssDir);

        // Extraire les règles communes
        const commonCSS = extractCommonRules(filesContent, 2); // Seuil : au moins 2 fichiers

        // Écrire les règles communes dans un fichier
        if (commonCSS) {
            await fs.writeFile(outputFile, commonCSS);
            console.log(`Fichier commun généré : ${outputFile}`);
        } else {
            console.log("Aucune règle commune trouvée.");
        }

        // Générer les fichiers spécifiques
        await generateSpecificFiles(filesContent, commonCSS ? commonCSS.split('\n') : []);
    } catch (error) {
        console.error("Une erreur est survenue :", error);
    }
}

// Exécuter la fonction principale
main();
