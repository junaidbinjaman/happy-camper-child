import { render } from "@wordpress/element";
import App from "./App";
import "./style/main.css";

// Function to render the App component
const renderApp = () => {
  const container = document.getElementById("user-activity-list-wrapper");

  // Check if the container exists
  if (container) {
    render(<App />, container);
  }
};

// Wait for the document to be fully loaded
document.addEventListener("DOMContentLoaded", renderApp);
