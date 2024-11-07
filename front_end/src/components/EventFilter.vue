<template>
    <div class="mb-4 sm:mb-6 flex justify-start gap-4 p-4 bg-white shadow-md rounded-lg">
        <!-- Filtro por nome -->
        <div class="flex-1 min-w-[150px]">
            <input v-model="filters.name" type="text" placeholder="Buscar por nome"
                class="w-full px-4 py-2 border rounded-md" @input="updateFilters" />
        </div>

        <!-- Filtro por data -->
        <div class="flex-1 min-w-[150px]">
            <input v-model="filters.date" type="date" class="w-full px-4 py-2 border rounded-md"
                @input="formatAndEmitDate" />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        // Recebe os filtros atuais do componente pai
        currentFilters: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            filters: { ...this.currentFilters }, // Inicializa com os filtros passados
        };
    },
    methods: {
        // Formata a data e emite para o componente pai
        formatAndEmitDate() {
            if (this.filters.date) {
                // Converte a data para o formato AAAA-MM-DD
                const date = new Date(this.filters.date);
                this.filters.date = date.toISOString().split('T')[0];
            }
            this.updateFilters();
        },
        // Emite os filtros para o componente pai
        updateFilters() {
            this.$emit('update-filters', this.filters);
        },
    }
};
</script>

<style scoped>
/* Container do filtro, ajustando o espaçamento e alinhamento */
div {
    display: flex;
    gap: 16px; /* Espaçamento entre os filtros */
    justify-content: flex-start;
    flex-wrap: wrap; /* Permite que os filtros se ajustem em telas menores */
}

/* Ajuste no tamanho dos filtros */
div>div {
    flex: 1;
    min-width: 150px; /* Diminuímos a largura mínima dos filtros */
}

/* Responsividade: em telas pequenas, os filtros ficam 100% da largura */
@media (max-width: 640px) {
    div {
        flex-direction: column; /* Filtros ficam em coluna */
    }

    div>div {
        min-width: 100%; /* Ocupa toda a largura disponível */
    }
}

/* Ajuste nos campos para garantir consistência visual */
input {
    width: 100%;
    padding: 8px;
    border-radius: 8px;
    border: 1px solid #ccc;
}
</style>
