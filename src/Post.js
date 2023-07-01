import { React, useEffect } from "react";

const Post = () => {
  useEffect(() => {
    const createPost = async () => {
      const postData = {
        title: "New post title is here",
        content: "lorem imsum is going to be here in this content section to help you create a new post etc",
        status: "publish",
      };

      try {
        // fetching data
        const response = await fetch('/wp-json/wp/v2/posts', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Authorization: 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vcmVhY3QtcGx1Z2luLWRldi5sb2NhbCIsImlhdCI6MTY4ODEyMzA3OSwibmJmIjoxNjg4MTIzMDc5LCJleHAiOjE2ODg3Mjc4NzksImRhdGEiOnsidXNlciI6eyJpZCI6IjEifX19.JAYLX_9GIZ-wdngvpbW-HuAsJL68Az4nyXyXHgJOrCE',
            'X-WP-NONCE': jobplace_script_data.nonce
          },
          body: JSON.stringify(postData)
        })

        // Throwing error
        if (!response.ok) {
          throw new Error('Something went wring with fetching your data');
        }

        // Storing response from WP
        const data = await response.json();
        console.log(data);

      } catch (error) {
        console.error(error)
      }
    };
    createPost();
  }, []);
  return (
    <div>
      <h1>Creating a post from this component {jobplace_script_data.nonce}</h1>
    </div>
  );
};

export default Post;
