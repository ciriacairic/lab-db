import React from 'react';
import ReactDOM from 'react-dom/client';

function App() {
    return <h1>LBD Reviews</h1>;
}

const rootElement = document.getElementById('app');
if (rootElement) {
    const root = ReactDOM.createRoot(rootElement);
    root.render(<App />);
}