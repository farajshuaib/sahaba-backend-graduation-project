import { Request, Response, NextFunction } from "express";
import jwt from "jsonwebtoken";
import { hashPassword, validatePassword } from "../utils";
import { create, update, getById } from "../models/Users";
import { validationResult } from "express-validator";

const authenticate = async (req: Request, res: Response) => {
  try {
    const errors = validationResult(req);
    const { wallet_address } = req.body;
    const authToken = req.headers.authorization;

    if (!errors.isEmpty()) {
      return res.status(400).json({
        errors: errors.array(),
        message: "Invalid argument (invalid request payload)",
      });
    }

    if (!authToken) {
      // create new user...
      const userData = await create({
        wallet_address,
      });
      const signedToken = jwt.sign(
        {
          userId: userData.id,
          wallet_address: userData.wallet_address,
        },
        process.env.JWT_SECRET || "",
        {
          expiresIn: "1m",
        }
      );
      if (userData && userData.id && signedToken) {
        await update(userData.id, { ...userData, token: signedToken });
      }
      return res.status(200).json({
        message: "user created successfully",
        data: userData,
        token: signedToken,
      });
    }

    const verifiedUser = (await jwt.verify(
      authToken,
      process.env.JWT_SECRET || ""
    )) as MyToken;
    if (!verifiedUser) return res.status(401).send("Unauthorized request");
    if (verifiedUser.exp < Date.now().valueOf() / 1000) {
      return res.status(401).json({
        error: "JWT token has expired, please login to obtain a new one",
      });
    }
    const user = await getById(+verifiedUser.userId);
    if (!user) return res.status(401).json({ message: "user does not exist" });
    const token = jwt.sign({ userId: user.id }, process.env.JWT_SECRET || "", {
      expiresIn: "1m",
    });
    res.status(200).json({
      data: user,
      token,
    });
  } catch (error) {
    res.status(500).json({
      message: "server error",
      error,
    });
  }
};

export { authenticate };
