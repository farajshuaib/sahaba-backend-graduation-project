import { Request, Response } from "express";
import { body, param } from "express-validator";

const categorySchema = [
  body("name").not().isEmpty().trim().escape(),
  param("id").trim().escape(),
];

export { categorySchema };
