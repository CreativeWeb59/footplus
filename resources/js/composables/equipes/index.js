export default function useEquipe() {
    const add = async (equipeId) => {
        let response = await axios.post('/api/equipes',{
            equipeId: equipeId
        });
    }
    return {
        add, 
    }
}