"use client"
import { createContext, ReactNode, useContext, useState } from "react";


type AuthContextType = {
    isAuthenticated: boolean,
    login: (username: string, password: string) => Promise<boolean>,
    logout: () => void,
    username: string,
    token: string,
    authority: string[],
    hasRole: (role: string) => boolean,
};

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export const AuthProvider: React.FC<{ children: ReactNode }> = ({ children }) => {
    const [isAuthenticated, setAuthenticated] = useState(false)

    const [username, setUsername] = useState<string>("")

    const [token, setToken] = useState<string>("")
    const [authority, setAuthority] = useState<string[]>([])

    const hasRole = (role: string) => authority.includes(role);

    const login = async (username: string, password: string): Promise<boolean> => {
        try {
            const response = await fetch('http://localhost/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                mode: 'cors',
                credentials: 'include',
                body: JSON.stringify({ username, password }),
            });

            if (!response.ok) {
                throw new Error('Login failed');
            }

            const data = await response.json();
            setAuthenticated(true);
            setUsername(username);
            setToken(data.token);
            setAuthority(data.authority || []);
            return true;
        } catch (error) {
            console.error("Login error:", error);
            return false;
        }
    };

    const logout = () => {
        setAuthenticated(false)
        setToken("")
        setUsername("")
        setAuthority([]);
    };

    return (
        <AuthContext.Provider value={ {isAuthenticated, login, logout, username, token, authority, hasRole}  }>
            {children}
        </AuthContext.Provider>
    );
};

export const useAuth = (): AuthContextType => {
    const context = useContext(AuthContext);
    if (!context) {
        throw new Error('useAuth must be used within an AuthProvider');
    }
    return context;
};