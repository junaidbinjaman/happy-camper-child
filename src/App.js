import React, { useEffect } from "react";
import Media from "./Media";

const App = () => {
  useEffect(() => {
    const getPosts = async () => {
      try {
        const response = await fetch("/wp-json/wp/v2/posts");

        if (response.ok) {
          const data = await response.json();
          console.log(data);
        } else {
          throw new Error(
            "Something went wrong with data fetching, contact your developer"
          );
        }
      } catch (error) {
        console.error(error);
      }
    };
    getPosts();
  }, []);
  return (
    <div>
      <h1>Hello, World from Junaid Bin Jaman</h1>
      <Media />
    </div>
  );
};

export default App;
