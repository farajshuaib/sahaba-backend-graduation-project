import express from "express";
import jwt from "jsonwebtoken";

const isAuthenticated = (
  req: express.Request,
  res: express.Response,
  next: express.NextFunction
) => {
  const token = req.headers.authorization;

  if (!token) {
    return res.status(403).send("A token is required for authentication");
  }

  // check json web token exists & is verified
  try {
    const verifiedUser = jwt.verify(
      token,
      process.env.JWT_SECRET || ""
    ) as MyToken;

    if (verifiedUser.exp < Date.now().valueOf() / 1000) {
      return res.status(401).json({
        error: "JWT token has expired, please login to obtain a new one",
      });
    }
    next();
  } catch (err) {
    return res.status(401).send("Invalid Token");
  }
  return next();
};

export { isAuthenticated };
