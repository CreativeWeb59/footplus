export default function useClassement() {
    const add = async (classementId) => {
        let response = await axios.post('/api/classements',{
            classementId: classementId
        });
    }
    return {
        add, 
    }
}