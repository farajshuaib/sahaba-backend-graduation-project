import { Request, Response } from "express";
import { body, param, header } from "express-validator";

const categorySchema = [
  body("name").not().isEmpty().trim().escape(),
  param("id").trim().escape(),
];

const authenticateSchema = [
  body("wallet_address").not().isEmpty().trim().escape(),
  header("authorization").trim().escape(),
];

export { categorySchema, authenticateSchema };
