
// Type definition for the global variable injected by WordPress
declare global {
  interface Window {
    bdcommercePlugin?: {
      apiUrl: string;
      nonce: string;
      adminUrl: string;
      siteUrl: string;
      assetsUrl: string;
    };
  }
}

export const getBaseApiUrl = (): string => {
  // If running inside WordPress Admin
  if (window.bdcommercePlugin?.apiUrl) {
    return window.bdcommercePlugin.apiUrl;
  }
  
  // Fallback for local development (assumes api folder is served from root or proxied)
  // Adjust this if your local dev setup differs
  return '/api/';
};

export const getAssetsUrl = (): string => {
    if (window.bdcommercePlugin?.assetsUrl) {
        return window.bdcommercePlugin.assetsUrl;
    }
    return '/assets/';
};
