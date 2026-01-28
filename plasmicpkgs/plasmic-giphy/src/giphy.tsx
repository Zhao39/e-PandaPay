import { GiphyFetch } from "@giphy/js-fetch-api";
import { IGif } from "@giphy/js-types";
import { ComponentMeta } from "@plasmicapp/host";
import React, { useEffect, useState } from "react";
import { useFetch } from "./hooks/useFetch";

export function ensure<T>(x: T | null | undefined): T {
  if (x === null || x === undefined) {
    debugger;
    throw new Error(`Value must not be undefined or null`);
  } else {
    return x;
  }
}

const modulePath = "@plasmicpkgs/plasmic-giphy";

interface GiphyProps {
  searchTerm: string;
  className: string;
  noLayout?: boolean;
}

export const GiphyMeta: ComponentMeta<GiphyProps> = {
  name: "hostless-giphy",
  displayName: "Giphy",
  importName: "Giphy",
  importPath: modulePath,
  providesData: true,
  description: "Fetches Giphy data and render it",
  props: {
    searchTerm: {
      type: "string",
      displayName: "Search Term",
      description: "Search term for fetching gif ",
      defaultValue: "Cat",
    },
  },
};

export function Giphy({ searchTerm, className }: GiphyProps) {
  const id = useFetch({ keyword: searchTerm });
  const [gif, setGif] = useState<IGif | null>(null);

  const apiKey = process.env.GIPHY_API_KEY || process.env.NEXT_PUBLIC_GIPHY_API_KEY || "";
  if (!apiKey) {
    console.error("GIPHY_API_KEY environment variable is not set");
    return <div>Error: GIPHY_API_KEY not configured</div>;
  }
  const gf = new GiphyFetch(apiKey);
  useEffect(() => {
    const fetchGif = async () => {
      if (!id) {
        return null;
      }
      const { data } = await gf.gif(id);
      setGif(data);
      return data;
    };
    fetchGif();
  }, [id]);

  return (
    <img
      src={gif?.images.downsized_medium.url}
      alt="Gif"
      className={className}
    />
  );
}
