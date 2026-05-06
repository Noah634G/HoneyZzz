/**
 * domoticz.js
 * Inclure dans chaque page qui a besoin de données capteurs :
 * <script src="domoticz.js"></script>
 */

const Domoticz = {

    /**
     * Récupère un ou plusieurs capteurs.
     * 
     * @param {number|number[]} idx  - Un idx ou un tableau d'idx
     * @returns {Promise<object>}    - Les données capteurs
     * 
     * Exemples :
     *   const data = await Domoticz.get(4);
     *   const data = await Domoticz.get([4, 5, 6]);
     */
    async get(idx) {
        const ids = Array.isArray(idx) ? idx : [idx];

        // Construit ?idx[]=4&idx[]=5&idx[]=6
        const params = ids.map(i => `idx[]=${i}`).join('&');
        const url    = `api_domoticz.php?${params}`;

        const response = await fetch(url, { cache: 'no-store' });

        if (!response.ok) {
            throw new Error(`Erreur HTTP ${response.status}`);
        }

        return await response.json();
    },

    /**
     * Poll automatique — appelle un callback toutes les X ms.
     * Retourne un ID pour pouvoir stopper le polling.
     * 
     * @param {number|number[]} idx       - Capteur(s) à surveiller
     * @param {function}        callback  - Fonction appelée à chaque mesure
     * @param {number}          intervalle - En ms (défaut : 5000)
     * 
     * Exemple :
     *   const poll = Domoticz.poll(4, (capteurs) => {
     *       document.getElementById('watt').textContent = capteurs['4'].valeur;
     *   }, 5000);
     * 
     *   // Pour arrêter :
     *   Domoticz.stop(poll);
     */
    poll(idx, callback, intervalle = 5000) {
        const run = async () => {
            try {
                const data = await Domoticz.get(idx);
                if (data.capteurs) callback(data.capteurs, null);
            } catch (err) {
                callback(null, err);
            }
        };

        run(); // premier appel immédiat
        return setInterval(run, intervalle);
    },

    /**
     * Arrête un poll.
     * @param {number} pollId - L'ID retourné par Domoticz.poll()
     */
    stop(pollId) {
        clearInterval(pollId);
    }
};