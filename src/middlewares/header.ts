import express from "express";

const useHeader = (
  req: express.Request,
  res: express.Response,
  next: express.NextFunction
) => {
  res.setHeader("Access-Control-Allow-Origin", "*");
  res.setHeader("Content-Type", "application/json");
  res.setHeader("Accept", "application/json");
  res.setHeader("Response-type", "application/json");
  res.setHeader(
    "Access-Control-Allow-Headers",
    "Origin, X-Requested-With, Content-Type, Accept, Authorization"
  );
  res.setHeader("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE");
  next();
};

export default useHeader;
