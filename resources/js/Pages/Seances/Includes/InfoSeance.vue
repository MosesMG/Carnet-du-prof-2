<script setup>
defineProps({
    presences: Array
})
</script>

<template>
    <table class="table table-striped my-5 w-50 mx-auto">
        <thead class="table-light">
            <tr>
                <th>Nom & Prénom(s)</th>
                <th class="text-center">Présent(e)</th>
                <th class="text-center">Note</th>
            </tr>
        </thead>
        <tbody>
            <template v-for="presence in presences" :key="presence.id">
                <tr v-for="etudiant in presence.etudiants" :key="etudiant.id">
                    <td>{{ etudiant.nom.toUpperCase() }} {{ etudiant.prenom }}</td>
                    <td class="text-center">
                        <span v-if="etudiant.pivot.presence" class="badge bg-success">Oui</span>
                        <span v-else class="badge bg-danger">Non</span>
                    </td>

                    <td class="text-center">
                        <span v-if="etudiant.pivot.plus !== null">{{ etudiant.pivot.plus }}</span>
                        <span v-else>-</span>
                    </td>
                </tr>
            </template>
        </tbody>
    </table>
</template>
