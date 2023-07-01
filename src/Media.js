import React, { useState } from "react";

const Media = () => {
  const [mediaSrc, setMediaSrc] = useState("");

  const handleMedia = async (e) => {
    const file = e.target.files[0];
    const reader = new FileReader();

    reader.onload = async (event) => {
      setMediaSrc(event.target.result);
      console.log(event.target.result);

      // Convert data URL to Blob
      const blob = dataURLtoBlob(event.target.result);

      // Create form data and append the Blob
      const formData = new FormData();
      formData.append("file", blob, file.name);

      // Set the headers
      const curHeaders = new Headers();
      curHeaders.append("Authorization", "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vcmVhY3QtcGx1Z2luLWRldi5sb2NhbCIsImlhdCI6MTY4ODEyMzA3OSwibmJmIjoxNjg4MTIzMDc5LCJleHAiOjE2ODg3Mjc4NzksImRhdGEiOnsidXNlciI6eyJpZCI6IjEifX19.JAYLX_9GIZ-wdngvpbW-HuAsJL68Az4nyXyXHgJOrCE");
      curHeaders.append("X-WP-Nonce", jobplace_script_data.nonce);
      curHeaders.append("Content-Disposition", 'form-data; filename=\''+file.name+'\'')

      // Make the POST request to the http://react-plugin-dev.local/wp-json/wp/v2/media endpoint
      try {
        const response = await fetch("http://react-plugin-dev.local/wp-json/wp/v2/media", {
          method: "POST",
          headers: curHeaders,
          body: formData,
        });

        if (!response.ok) {
          throw new Error("Media upload failed");
        }

        const mediaData = await response.json();
        console.log(mediaData); // Information about the uploaded media

        // Optionally, you can retrieve the URL of the uploaded media
        const mediaURL = mediaData.source_url;
        console.log(mediaURL);
      } catch (error) {
        console.error(error);
      }
    };

    if (file) {
      reader.readAsDataURL(file);
      console.log(file);
    } else {
      setMediaSrc("");
    }
  };

  // Function to convert data URL to Blob
  const dataURLtoBlob = (dataURL) => {
    const arr = dataURL.split(",");
    const mime = arr[0].match(/:(.*?);/)[1];
    const bstr = atob(arr[1]);
    let n = bstr.length;
    const u8arr = new Uint8Array(n);
    while (n--) {
      u8arr[n] = bstr.charCodeAt(n);
    }
    return new Blob([u8arr], { type: mime });
  };

  return (
    <div>
      {mediaSrc && <img src={mediaSrc} alt="" />}
      <form>
        <table className="form-table">
          <tbody>
            <tr>
              <th scope="row">
                <label htmlFor="input_id">Site logo</label>
              </th>
              <td>
                <input
                  onChange={handleMedia}
                  name="input_id"
                  type="file"
                  id="input_id"
                  className="regular-text"
                />
              </td>
            </tr>
          </tbody>
        </table>
        <p className="submit">
          <input
            type="submit"
            value="Save Changes"
            className="button-primary"
            name="Submit"
          />
        </p>
      </form>
    </div>
  );
};

export default Media;
