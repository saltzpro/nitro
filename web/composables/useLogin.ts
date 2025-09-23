export function useLogin() {
    
    const user = useUserStore()
    const auth = useSanctumUser();

    async function loginUser(payload:any) {
        await user.login(payload)
    }


    return {
        loginUser
    }
}