declare module "ipfs-api";

type ProductStatus = "published" | "blocked" | "pending";

interface Category {
  id?: number;
  name: string;
}

interface User {
  id?: number;
  username?: string;
  email?: string;
  wallet_address: string;
  bio?: string;
  banner_image?: string;
  facebook_url?: string;
  profile_photo?: string;
  twitter_url?: string;
  telegram_url?: string;
  created_at?: Date;
  updated_at?: Date;
  role_id?: number;
  token?: string;
}

interface Product {
  id: number;
  image_url: string;
  image_hash: string;
  user_id: number;
  title: string;
  description: string;
  collection_id: number;
  creator_address: string;
  price: string;
  status: string;
  created_at: Date;
  updated_at: Date;
}

interface Collection {
  id: number;
  name: string;
  description: string;
  category_id: number;
  banner_image: string;
  logo_image: string;
  website_url: string;
  facebook_url: string;
  telegram_url: string;
  twitter_url: string;
  istagram_url: string;
  payout_wallet_address: string;
  blockchain: string;
  is_sensitive_content: 0 | 1;
  creator_earnings: number;
}

interface MyToken {
  userId: string;
  wallet_address: string;
  exp: number;
}
