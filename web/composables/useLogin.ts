export function useLogin() {
    
    const user = useUserStore()
    const auth = useSanctumUser();

    async function loginUser(payload:any) {
        const getUser = await user.login(payload)

        if (getUser.data) {

        }
    }


    return {
        loginUser
    }
}