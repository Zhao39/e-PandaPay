import { useState, useEffect } from "react";

interface HookProps {
    keyword: string
}
export const useFetch = ({ keyword }: HookProps) => {
    const [giphyId, setGiphyId] = useState("");

    useEffect(() => {
        if (keyword) fetchGiphy();
    }, [keyword]);

    const fetchGiphy = async () => {
        try {
            const apiKey = process.env.GIPHY_API_KEY || process.env.NEXT_PUBLIC_GIPHY_API_KEY || "";
            if (!apiKey) {
                console.error("GIPHY_API_KEY environment variable is not set");
                return;
            }
            const response = await fetch(
                `https://api.giphy.com/v1/gifs/search?api_key=${apiKey}&q=${keyword
                    .split(" ")
                    .join("")}&limit=1`
            );

            const { data } = await response.json();

            setGiphyId(data[0]?.id);
        } catch (error) {
            console.log("Error in gif api retrieval: ", error);
            setGiphyId("");
        }
    };
    return giphyId;
};
